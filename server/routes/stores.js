const express = require('express');
const { StoreSelectRule, validate } = require('../middleware/sanitizer');
const verifyToken = require('../middleware/verifyToken');
const Cart = require('../models/cart');
const Merchants = require('../models/merchant');
const { Client } = require("@googlemaps/google-maps-services-js");

const client = new Client({});

const router = express.Router();

router.get('/merchants/:userAddress', verifyToken, async (req, res) => {
	try {
		let stores = await Merchants.find({}).exec();

		if (stores) {
			let locations = '';

			stores.forEach(store => locations += store.location + '|');
			locations.slice(0, -1);

			client.distancematrix({
				params: {
					origins: [ locations ],
					destinations: [ req.params.userAddress ],
					key: process.env.GMAPS_API_KEY,
				}
			})
			.then((resApi) => {
				if (resApi.status === 200) {
					if (resApi.data.status === 'OK') {

						let storesDistanceMatrix = [];

						resApi.data.rows.forEach((row, index) => {
							if (row.elements[0].distance.value < 50000) {
								let data = {
									_id: stores[index]._id,
									location: stores[index].location,
									name: stores[index].name,
									logo: stores[index].logo,
									distance: row.elements[0].distance,
									duration: row.elements[0].duration
								};
	
								storesDistanceMatrix.push(data);
							}
						});

						storesDistanceMatrix.sort((a, b) => a.distance.value - b.distance.value);

						res.send({
							'stores': storesDistanceMatrix
						});
					}
				}
			})
			.catch((error) => {
				console.log(error);
				res.send({
					'error': 'An unexpected error occured'
				});
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