const express = require('express');
const db = require('../utils/db.config');
const verifyToken = require('../middleware/verifyToken');
const { AddressRules, AddressRule, validate } = require('../middleware/sanitizer');
const jwt_decode = require('jwt-decode');

const router = express.Router();

router.post('/insert' , AddressRules(), validate, verifyToken, (req, res) => {
	const queryToCheckAddressLimitation = 'SELECT address, state FROM cc_address WHERE user_id = ?';
	const user = jwt_decode(req.headers['authorization']);

	db.execute(queryToCheckAddressLimitation, [user.id], (error, results) => {
		if (error) res.status(500).send({ 'error': error });

		if (results.length < 3) {
			if (results.some(row => row.address === req.body.address)) {
				res.send({ 'error' : 'Η διεύθυνση υπάρχει ήδη' });
			}
			else {
				const queryToAddAddress = "INSERT INTO cc_address (user_id, address, state, active) VALUES (? , ? , ? , 1)";
		
				db.execute(queryToAddAddress, [user.id, req.body.address, req.body.state], (error, results) => {
					if (error) res.status(500).send({ 'error': error });
	
					res.send({ 'status' : 'OK' });
				});
			}
		}
		else {
			res.send({ 'error': 'Δε μπορείτε να προσθέσετε άλλη διεύθυνση.'});
		}
	});
});

router.post('/delete', AddressRule(), validate, verifyToken, (req, res) => {
	const queryToDeleteAddress = 'DELETE FROM cc_address WHERE address = ? AND user_id = ?';

	const user = jwt_decode(req.headers['authorization']);

	db.execute(queryToDeleteAddress, [req.body.address, user.id], (error, results) => {
		if (error) res.status(500).send({ 'error': error });

		try {	
			if (results !== undefined) {
				res.send({ 'status' : 'OK' });
			}
		} 
		catch (error) {
			res.status(500).send({ 'error': 'An unexpected error occured. Try again' });
		}
	});
});

router.get('/addresses', verifyToken , (req, res) => {
	const queryToFetchAddresses = 'SELECT address, state, active FROM cc_address WHERE user_id = ?';

	const user = jwt_decode(req.headers['authorization']);

	db.execute(queryToFetchAddresses, [user.id], (error, results) => {
		if (error) res.status(500).send({ 'error': error });

		if  (results !== undefined) {
			if (results.length > 0) {
				res.send({ 'hasAddress': true, 'addresses': results });
			}
			else {
				res.send({ 'hasAddress': false });
			}
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
								WHERE cc_orders.user_id = ?
								GROUP BY cc_orders.id, cc_orders.date, cc_orders.time
								ORDER BY cc_orders.id DESC`;
	
	const user = jwt_decode(req.headers['authorization']);

	db.execute(queryToFetchOrders, [user.id], (error, results) => {
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