const r = require('rethinkdb');

r.connect({
	host: 'localhost',
	port: 49160,
	db: 'CC_Orders'
}, (error, conn) => {
	if (error) {
		throw error;
	}
	//fetch documents
	r.db('CC_Orders').table('orders').run(conn , function(err, cursor) {
		if (err) throw err;
		cursor.toArray(function(err, result) {
			if (err) throw err;
			console.log(JSON.stringify(result, null, 2));
		});
	});	
});