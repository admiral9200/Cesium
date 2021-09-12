const r = require('rethinkdb');
let rethinkConnection;

r.connect({
	host: 'localhost',
	port: 49154,
	db: 'CC_Orders',
}, (error, conn) => {
	if (error) {
		throw error;
	}
	rethinkConnection = conn;
	console.log('RethinkDB connected...');

	r.table('orders').filter(r.row("store_id").eq("38423bf3-ea4b-5e77-94a6-27075babee9dd4f3s")).changes().run(rethinkConnection, function(err, cursor) {
		if (err) throw err;
		cursor.each(function(err, row) {
			if (err) throw err;
			console.log(JSON.stringify(row, null, 2));
		});
	});

});