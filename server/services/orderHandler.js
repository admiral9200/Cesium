const jwt_decode = require('jwt-decode');
const jwt = require('jsonwebtoken');
const cert = require('../utils/jwt.config');
const rethink = require('rethinkdb');
const uniqid = require('uniqid');

const PORT = 49160;

module.exports = (io, socket) => {
	socket.on("order:client:send", (order) => {
		const date = new Date();
		const orderDate = date.toLocaleString('en-GB', {
			timeZone: 'Europe/Athens'
		});

		const orderID = uniqid.time('CC');
		order.id = orderID;
		order.date = orderDate;
		order.confirmed = false;

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
					console.log("Order inserted");
					socket.disconnect();
				}
			});
		});
	});
	
	socket.on('feed', (token) => {
		jwt.verify(token, cert.public, (error, decoded) => {
			if (error) {
				if (error.name === 'TokenExpiredError') {
					socket.disconnect();
				}
				else {
					socket.disconnect();
				}
			}
			// TODO Maybe check user token to verify if it is not expired.. Use Redis for this
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
				.changes()
				.run(conn, function(err, cursor) {
					if (err) throw err;
					
					cursor.each(function(err, row) {
						if (err) throw err;
						
						if (row.new_val !== null && Object.keys(row.new_val).length > 0) {
							socket.emit('new_order', row.new_val);
						}
					});
				});
			});
		});
	});

	//Close sockets events
	socket.on('stopFeed', () => {
		socket.disconnect();
	});
};