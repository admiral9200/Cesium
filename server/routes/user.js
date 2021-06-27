const express = require('express');
const db = require('../utils/db.config');
const verifyToken = require('../middleware/verifyToken');
const jwt_decode = require('jwt-decode');
const Cart = require('../models/cart');

const router = express.Router();

router.get('/info', verifyToken, (req, res) => {
	const queryToGetUserDetails = 'SELECT id, firstName, lastName, email, mobile FROM cc_users WHERE id = ?';

	const user = jwt_decode(req.headers.authorization);

	db.execute(queryToGetUserDetails, [user.id], (error, results) => {
		if (error) res.send({'error': error });

		if (results.length > 0) {
			res.send({
				id: results[0].id,
				name: results[0].firstName, 
				surname: results[0].lastName, 
				email: results[0].email, 
				mobile: results[0].mobile 
			});
		}
	});
});

router.get('/addresses', verifyToken , (req, res) => {
	const queryToFetchAddresses = 'SELECT address, floor, ringbell, active FROM cc_address WHERE user_id = ?';

	const user = jwt_decode(req.headers.authorization);

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

router.get('/cart', verifyToken, (req, res) => {
	const user = jwt_decode(req.headers.authorization);

	Cart.find({ user_id: user.id }, (error, results) => {
		if (error) {
			res.send({ 'error': error });
		}
		else {
			if (results.length > 0) {
				const payload = {
					storeId: results[0].store_id,
					products: results[0].products
				};
				res.send({ 'cart': payload });
			}
			else {
				const payload = {
					storeId: '',
					products: []
				};
				res.send({ 'cart': payload });
			}
		}
	});
});

module.exports = router;