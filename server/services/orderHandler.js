const jwt_decode = require('jwt-decode');
const jwt = require('jsonwebtoken');
const cert = require('../utils/jwt.config');
const rethink = require('rethinkdb');
const uniqid = require('uniqid');

const Merchant = require('../models/merchant');

const PORT = 49154;

module.exports = (io, socket) => {
	// * CLIENT SOCKET EVENTS LISTENERS
	socket.on("order:client:send", (token, order) => {
		jwt.verify(token, cert.public, (error, decoded) => {
			if (error) {
				socket.disconnect();
			}
			else {
				const date = new Date();

				order.id = uniqid.time('CC');
				order.date = date.toLocaleString('en-GB', {
					timeZone: 'Europe/Athens'
				});
				order.confirmed = false;
				order.completed = false;
				order.cancelled = false;
				order.cancelledReason = "";
				order.loaderInCard = false;

				rethink.connect({
					host: 'localhost',
					port: PORT,
					db: 'CC_Orders',
				}, (error, conn) => {
					if (error) {
						throw error;
					}

					rethink.table('orders')
					.insert(order)
					.run(conn, (err, result) => {
						if (err) throw err;

						if (result.inserted === 1) {
							socket.emit("order:client:await_confirm", order.id);
						}
					});
				});
			}
		});
	});

	socket.on('order:merchant:confirm', (token, orderID) => {
		jwt.verify(token, cert.public, (error, decoded) => {
			if (error) {
				socket.disconnect();
			}
			else {
				rethink.connect({
					host: 'localhost',
					port: PORT,
					db: 'CC_Orders',
				}, (error, conn) => {
					if (error) {
						throw error;
					}

					rethink.table('orders')
					.filter(rethink.row("id").eq(orderID))
					.changes()
					.run(conn, function(err, cursor) {
						if (err) throw err;
						
						cursor.each(function(err, row) {
							if (err) throw err;
							
							if (row.new_val !== null && Object.keys(row.new_val).length > 0 && row.new_val.confirmed) {
								socket.emit('order:client:confirmed', new Date().toLocaleString('en-GB', {
									timeZone: 'Europe/Athens'
								}));
							}
						});
					});
				});
			}
		});
	});

	// * MERCHANT SOCKET EVENT LISTENERS	
	socket.on('merchant:feed', (token) => {
		jwt.verify(token, cert.public, (error, decoded) => {
			if (error) {
				socket.disconnect();
				// * Reason for disconnect
			}
			else {
				const merchant = jwt_decode(token);

				rethink.connect({
					host: 'localhost',
					port: PORT,
					db: 'CC_Orders',
				}, (error, conn) => {
					if (error) {
						throw error;
					}

					rethink.table('orders')
					.filter(rethink.row("store")("_id").eq(merchant.id))
					.changes({ includeTypes: true })
					.run(conn, function(err, cursor) {
						if (err) throw err;
						
						cursor.each(function(err, row) {
							if (err) throw err;

							if (row.type === 'change' && row.new_val.confirmed) {
								socket.emit('merchant:new_order:change', row.new_val.id);
							}
							else {
								if (row.new_val !== null && Object.keys(row.new_val).length > 0) {
									socket.emit('merchant:new_order:add', row.new_val);
								}
								else if (row.old_val !== null && Object.keys(row.old_val).length > 0) {
									socket.emit('merchant:new_order:remove', row.old_val);
								}
							}
						});
					});
				});
			}
		});
	});

	socket.on('merchant:order:confirm', (token, orderId) => {
		jwt.verify(token, cert.public, (error, decoded) => {
			if (error) {
				socket.disconnect();
			}
			else {
				rethink.connect({
					host: 'localhost',
					port: PORT,
					db: 'CC_Orders',
				}, (error, conn) => {
					if (error) {	
						socket.disconnect();
					}
					else {
						rethink.table('orders')
						.filter(rethink.row("id").eq(orderId))
						.update({ confirmed: true })
						.run(conn, (error, order) => {
							if (error) {
								throw error;
							}

							if (order.replaced) {

							}
						});
					}
				});
			}
		});
	});

	socket.on('merchant:order:cancel', (token, order) => {
		jwt.verify(token, cert.public, (error, decoded) => {
			if (error) {
				socket.disconnect();
			}
			else {
				order.cancelled = true;
				
				Merchant.findOneAndUpdate({
					_id: order.store._id
				},
				{
					$push: {
						orders: [ order ]
					}
				},
				{
					new: true
				},
				(error, result) => {
					if (error) {
						throw error;
					}
				});


				rethink.connect({
					host: 'localhost',
					port: PORT,
					db: 'CC_Orders',
				}, (error, conn) => {
					if (error) {
						socket.disconnect();
					}
					else {
						rethink.table('orders')
						.filter(rethink.row("id").eq(order.id))
						.delete()
						.run(conn, (error, result) => {
							if (error) {
								throw error;
							}

							if (result.deleted > 0) {
								socket.emit('merchant:order:cancelled', order.cancelledReason);
							}
						});
					}
				});
			}
		});
	});

	// * Close socket events
	socket.on('merchant:stopFeed', () => {
		socket.disconnect();
	});

	socket.on('order:completeddisconnect', () => {
		socket.disconnect();
	});
};