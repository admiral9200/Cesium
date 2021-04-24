const mysql = require('mysql2');

let db = mysql.createConnection({
	host: 'localhost',
	user: 'root',
	password: 'root',
	database: 'chip_coffee'
});

db.connect((error) => {
	if (error) throw error;
	console.log('Cofy Database is connected successfully');
});

module.exports = db;