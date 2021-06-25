const express = require('express');
// const {  } = require('../middleware/sanitizer');
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

router.post('/select', verifyToken, (req, res) => {
	
});

module.exports = router;