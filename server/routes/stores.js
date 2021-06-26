const express = require('express');
const { StoreSelectRule, validate } = require('../middleware/sanitizer');
const verifyToken = require('../middleware/verifyToken');
const jwt_decode = require('jwt-decode');

const Cart = require('../models/cart');
const Merchants = require('../models/merchant');

const router = express.Router();

router.get('/merchants', verifyToken, async (req, res) => {
	const user = jwt_decode(req.headers.authorization);

	try {	
		// let cart = await Cart.find({ user_id: user.id }).exec();
		let stores = await Merchants.find({}).exec();

		if (stores) {
			res.send({
				'stores': stores
			});
		}
	} 
	catch (error) {
		console.log(error);
		res.send({
			'error': 'An unexpected error occured'
		});
	}
});

router.post('/select', verifyToken, StoreSelectRule(), validate, (req, res) => {
	Cart.findOneAndUpdate(
		{ 
			user_id: req.body.user_id,
		},
		{
			store_id: req.body.store_id
		},
		(error, results) => {
			if (error) {
				res.send({ 'error': 'An unexpected error occured' });
				console.log(error);
			}

			if (results) {
				res.send({ 'ok': true });			
			}
		}
	);
});

module.exports = router;