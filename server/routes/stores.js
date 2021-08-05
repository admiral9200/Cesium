const express = require('express');
const jwt_decode = require('jwt-decode');
const verifyToken = require('../middleware/verifyToken');
const { StoreSelectRule, validate } = require('../middleware/sanitizer');
const { distanceMatrixMap } = require('../services/gmaps.core');

//Models require
const Cart = require('../models/cart');
const Merchants = require('../models/merchant');

const router = express.Router();

router.get('/user/:userAddress', verifyToken, async (req, res) => {
	const user = jwt_decode(req.headers.authorization);

	try {
		let stores = await Merchants.find({}).exec();

		if (stores !== null) {
			let locations = '';
			stores.forEach(store => locations += store.location + '|');
			locations.slice(0, -1);

			distanceMatrixMap(user, req.params.userAddress, stores, locations, res);
		}
		else {	
			res.send({
				'error': 'An unexpected error occured'
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

router.get('/:storeId', verifyToken, async (req, res) => {
	try {
		let store = await Merchants.findOne({
			_id: req.params.storeId
		})
		.exec();

		if (store !== null) {
			res.send({
				'store': {
					_id: store._id,
					name: store.name,
					location: store.location,
					logo: store.logo
				}
			});
		}
		else {
			res.send({
				'error': 'Δεν έχεις επιλέξει κατάστημα'
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
				res.send({ 
					'error': 'An unexpected error occured' 
				});
				console.log(error);
			}

			if (results) {
				res.send({ 
					'ok': true 
				});
			}
		}
	);
});

router.delete('/remove', verifyToken, (req, res) => {
	const user = jwt_decode(req.headers.authorization);
	
	Cart.findOneAndUpdate(
		{ 
			user_id: user.id,
		},
		{
			store_id: ''
		},
		(error, results) => {
			if (error) {
				res.send({ 
					'error': 'An unexpected error occured' 
				});
				console.log(error);
			}

			if (results) {
				res.send({ 
					'ok': true 
				});
			}
		}
	);
});

module.exports = router;