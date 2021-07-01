const express = require('express');
const verifyToken = require('../middleware/verifyToken');
const jwt_decode = require('jwt-decode');
const Cart = require('../models/cart');
const User = require('../models/user');

const router = express.Router();

router.get('/info', verifyToken, (req, res) => {
	const user = jwt_decode(req.headers.authorization);

	User.findOne({ _id: user.id, email: user.email }, (error, results) => {
		if (error) {
			console.log(error);
			res.send({
				'error': 'An unexpected error occured' 
			});
		}

		if (results !== null) {
			res.send({
				id: results.id,
				email: results.email,
				name: results.firstName,
				surname: results.lastName,
			});
		}
		else {
			res.send({
				'error': 'User does not exist' 
			});
		}
	});
});

router.get('/addresses', verifyToken , (req, res) => {
	const user = jwt_decode(req.headers.authorization);

	User.findOne({ _id: user.id, email: user.email }, (error, results) => {
		if (error) {
			res.send({ 
				'error': error 
			});
		}

		if (results !== null) {
			res.send({ 
				'hasAddress': true, 
				'addresses': results.addresses
			});
		}
		else {
			res.send({ 
				'hasAddress': false 
			});
		}
	});
});

router.get('/cart', verifyToken, (req, res) => {
	const user = jwt_decode(req.headers.authorization);

	Cart.find({ user_id: user.id }, (error, results) => {
		if (error) {
			res.send({ 
				'error': error 
			});
		}
		else {
			if (results.length > 0) {
				const payload = {
					storeId: results[0].store_id,
					products: results[0].products
				};

				res.send({ 
					'cart': payload 
				});
			}
			else {
				const payload = {
					storeId: '',
					products: []
				};

				res.send({ 
					'cart': payload 
				});
			}
		}
	});
});

module.exports = router;