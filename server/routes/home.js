const express = require('express');
const db = require('../utils/db.config');
const verifyToken = require('../middleware/verifyToken');
const { AddressRules, validate } = require('../middleware/sanitizer');
const jwt_decode = require('jwt-decode');

const router = express.Router();

router.post('/insert' , AddressRules(), validate, verifyToken, (req, res) => {
	const queryToCheckAddressLimitation = 'SELECT COUNT(*) as count FROM cc_address WHERE email = ?';

	db.execute(queryToCheckAddressLimitation, [req.body.user], (error, results) => {
		if (error) res.status(500).send({ 'error': error });

		if (results[0].count < 3) {
			const queryToAddAddress = "INSERT INTO cc_address (email, address, state, active) VALUES (? , ? , ? , 1)";

			db.execute(queryToAddAddress, [req.body.user, req.body.address, req.body.state], (error, results) => {
				if (error) res.status(500).send({ 'error': error });

				res.send({ 'status' : 'OK' });
			});
		}
		else {
			res.send({ 'status' : 'Δε μπορείτε να προσθέσετε άλλη διεύθυνση.' });
		}
	});
});

router.get('/addresses', verifyToken , (req, res) => {
	const queryToFetchAddresses = 'SELECT address, state, active FROM cc_address WHERE email = ?';

	let token = req.headers['authorization'];
	const user = jwt_decode(token);

	db.execute(queryToFetchAddresses, [user.email], (error, results) => {
		if (error) res.status(500).send({ 'error': error });

		if (results.length > 0) {
			res.send({ 'hasAddress': true, 'addresses': results });
		}
		else {
			res.send({ 'hasAddress': false });
		}
	});
});

router.get('/orders' , verifyToken , (req, res) => {
	const queryToFetchOrders = `SELECT 
								cc_orders.id,  
								cc_orders.date, 
								cc_orders.time, 
								GROUP_CONCAT(cc_orders_products.coffee) as coffees,
								GROUP_CONCAT(cc_orders_products.price) as price,
								GROUP_CONCAT(cc_orders_products.qty) as qty
								FROM cc_orders 
								INNER JOIN cc_orders_products ON cc_orders.id = cc_orders_products.id 
								WHERE cc_orders.email = ?
								GROUP BY cc_orders.id, cc_orders.date, cc_orders.time
								ORDER BY cc_orders.id DESC`;
	
	let token = req.headers['authorization'];
	const user = jwt_decode(token);

	db.execute(queryToFetchOrders, [user.email], (error, results) => {
		if (error) res.status(500).send({ 'error': error });

		if (results.length > 0) {
			res.send({ 'hasOrders': true, 'orders': results });
		}
		else {
			res.send({ 'hasOrders': false });
		}
	});
});

module.exports = router;