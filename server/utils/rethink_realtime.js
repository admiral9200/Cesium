const rethink = require('rethinkdb');
const test = '60dda9adbd113035b8124ae1';

rethink.connect({
	host: 'localhost',
	port: 49154,
	db: 'CC_Orders',
}, (error, conn) => {
	if (error) {
		throw error;
	}

	rethink.table('orders')
	.filter(rethink.row("store")("_id").eq(test))
	.changes()
	.run(conn, function(err, cursor) {
		if (err) throw err;
		cursor.each(function(err, row) {
			if (err) throw err;
			console.log(JSON.stringify(row, null, 2));
		});
	});

});