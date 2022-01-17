const jwt_decode = require('jwt-decode');
const rethink = require('rethinkdb');

const PORT = 49154;

module.exports = (io, socket) => {

	//* CLIENT SOCKET EVENTS
	socket.on('order:client:changes', (orderId) => {
		try {
			if (orderId) {
				rethink.connect({
					host: 'localhost',
					port: PORT,
					db: 'CC_Orders',
				}, (error, conn) => {
					if (error) throw error;
		
					rethink.table('orders')
					.filter(rethink.row("id").eq(orderId))
					.changes()
					.run(conn, function(err, cursor) {
						if (err) throw err;
						
						cursor.each(function(err, row) {
							if (err) throw err;
		
							if (Object.keys(row.new_val).length > 0) {
								if (row.new_val.confirmed) {
									socket.emit('order:client:confirmed', new Date().toLocaleString('en-GB', {
										timeZone: 'Europe/Athens'
									}));
								}
								else if (row.new_val.cancelled) {
									socket.emit('order:client:cancelled', row.new_val.cancelledReason);
								}
								else if (row.new_val.cancelled && row.new_val.cancelledReason !== '') {
									let res = {
										cancelled: row.new_val.cancelled,
										cancelledReason: row.new_val.cancelledReason
									};
			
									socket.emit('order:client:cancelled', res);
								}
							}
						});
					});
				});
			}
			else {
				throw 'No order id provided';
			}
		} 
		catch (error) {
			//! LOG ERROR
			console.log(error);
			socket.emit('order:client:error', error);
		}
	});

	//* MERCHANT SOCKET EVENT 
	socket.on('merchant:feed', () => {
		try {
			const merchant = jwt_decode(socket.handshake.query.token);

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
				.changes({ 
					includeTypes: true 
				})
				.run(conn, (err, cursor) => {
					if (err) throw err;
					
					cursor.each((err, row) => {
						if (err) throw err;

						if (row.type === 'add' && !row.new_val.confirmed && !row.new_val.cancelled && !row.new_val.completed && Object.keys(row.new_val).length > 0) {
							socket.emit('merchant:order:add', row.new_val);
						}
						else if (row.type === 'change' && row.new_val.cancelled && row.new_val.cancelledReason !== '') {
							let res = {
								cancelled: row.new_val.cancelled,
								cancelledReason: row.new_val.cancelledReason
							};

							socket.emit('order:client:cancelled', res);
						}
						else if (row.type === 'remove' && Object.keys(row.old_val).length > 0) {
							socket.emit('merchant:order:deleted', row.old_val.id);
						}
					});
				});
			});	
		} 
		catch (error) {
			//! LOG ERROR
			console.log(error);
			socket.emit('order:client:error', error);
		}
	});

	// * Close socket events
	socket.on('merchant:stopFeed', () => {
		socket.disconnect();
	});

	socket.on('order:client:disconnect', () => {
		socket.disconnect();
	});
};