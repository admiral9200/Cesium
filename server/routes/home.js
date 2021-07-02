const express = require('express');
const verifyToken = require('../middleware/verifyToken');
const { AddressRules, AddressRule, validate } = require('../middleware/sanitizer');
const jwt_decode = require('jwt-decode');
const User = require('../models/user');

const router = express.Router();

router.post('/insert' , AddressRules(), validate, verifyToken, (req, res) => {
	const user = jwt_decode(req.headers.authorization);

	User.findOne({ _id: user.id, email: user.email }, (error, results) => {
		if (error) {
			console.log(error);
			res.send({
				'error': 'An unexpected error occured' 
			});
		}

		if (results.addresses.length < 3) {
			let addressExists = results.addresses.some(row => {
				return row.route === req.body.address.route &&
						row.street_number === req.body.address.street_number;
			});

			if (addressExists) {
				res.send({ 
					'error' : 'Η διεύθυνση αυτή υπάρχει ήδη' 
				});
			}
			else {
				User.updateOne({ 
					_id: user.id, 
					email: user.email 
				},
				{
					$push: { addresses: [ req.body.address ]}
				},
				{
					new: true
				},
				(error, addressAdded) => {
					if (error) {
						res.send({ 'error': 'An unexpected error occured' });
						console.log(error);
					}

					if (addressAdded) {
						res.send({ 
							'completed' : true 
						});
					}
				});
			}
		}
		else {
			res.send({ 
				'error': 'Δε μπορείτε να προσθέσετε άλλη διεύθυνση.'
			});
		}
	});
});

router.post('/delete', AddressRule(), validate, verifyToken, (req, res) => {
	const user = jwt_decode(req.headers.authorization);

	User.findOneAndUpdate({
		_id: user.id, email: user.email
	},
	{
		"$pull": { "addresses": { "_id": req.body.id }}
	},
	{
		new: true
	},
	(error, results) => {
		if (error) {
			console.log(error);
			res.send({
				'error': 'An unexpected error occured' 
			});
		}

		if (results.addresses.find(address => address._id !== req.body.id)) {
			res.send({ 
				'deleted' : true,
				'msg': 'Η διεύθυνση διαγράφηκε με επιτυχία.'
			});
		}
		else {
			res.send({
				'error': 'An unexpected error occured' 
			});
		}
	});
});

router.get('/orders' , verifyToken , (req, res) => {
	const user = jwt_decode(req.headers.authorization);

	User.findOne({ _id: user.id, email: user.email }, (error, results) => {
		if (error) {
			console.log(error);
			res.send({
				'error': 'An unexpected error occured' 
			});
		}

		if (results.orders.length > 0) {
			res.send({ 
				'hasOrders': true, 'orders': results 
			});
		}
		else {
			res.send({ 
				'hasOrders': false 
			});
		}
	});
});

module.exports = router;