const r = require('rethinkdb');
let rethinkConnection;

r.connect({
	host: 'localhost',
	port: 49154,
	db: 'CC_Orders'
}, (error, conn) => {
	if (error) {
		throw error;
	}
	rethinkConnection = conn;
	console.log('RethinkDB connected...');

	/* r.db('CC_Orders').tableCreate('orders').run(rethinkConnection, function(err, result) {
		if (err) throw err;
		console.log(JSON.stringify(result, null, 2));
	}); */

	r.db('CC_Orders').table('orders').insert([
		{ 
			store_id: "38423bf3-ea4b-5e77-94a6-27075babee9dd4f3s",
			name: "Lungo", 
			content: [
				{
					title: "Espresso", 
					content: "The Cylon War is long over..."
				}
			]
		}
	]).run(rethinkConnection, function(err, result) {
		if (err) throw err;
		console.log(JSON.stringify(result, null, 2));
	});

	//fetch documents
/* 	r.db('CC_Orders').table('orders').run(rethinkConnection , function(err, cursor) {
		if (err) throw err;
		cursor.toArray(function(err, result) {
			if (err) throw err;
			console.log(JSON.stringify(result, null, 2));
		});
	}); */



	
});