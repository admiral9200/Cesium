const express = require('express');
const { reorderSanitizeRules, cartSanitizeRules, CartOperationsRules , validate } = require('../middleware/sanitizer');
const verifyToken = require('../middleware/verifyToken');
const Coffee = require('../models/coffee');
const Cart = require('../models/cart');
const tools = require('../libs/functions');

const router = express.Router();

router.get('/coffees', verifyToken, (req, res) => {
	Coffee.find({}, (error, results) => {
		if (error) {
			res.send({ 'error': error });
		}

		if (results) {
			res.send({ 'menu': results });
		}
	});
});

router.post('/cart', verifyToken, cartSanitizeRules(), validate, (req, res) => {

	Cart.find({ user_id: req.body.user_id } , (error, results) => {
		if (error) {
			res.send({ 'error': error });
		}

		if (results.length === 0) {
			const cart = new Cart({
				dateCreated: new Date(),
				user_id: req.body.user_id,
				products: [{ 
					name: req.body.c_name,
					size: req.body.c_size,
					sugar: req.body.c_sugar,
					sugarType: req.body.c_sugartype,
					blends: req.body.c_blends,
					decaf: req.body.c_decaf,
					adds: req.body.c_adds,
					extras: req.body.c_extras,
					qty: req.body.c_qty
				}]
			});
			
			cart
			.save()
			.then(() => 
				res.send({ 
					'success': true,
					'msg': 'Προστέθηκε στο καλάθι'
				})
			)
			.catch(error => res.send({ 'error': error }) );
		}
		else if (results.length > 0) {
			let coffee = {
				name: req.body.c_name,
				size: req.body.c_size,
				sugar: req.body.c_sugar,
				sugarType: req.body.c_sugartype,
				blends: req.body.c_blends,
				decaf: req.body.c_decaf,
				adds: req.body.c_adds,
				extras: req.body.c_extras,
				qty: req.body.c_qty
			};

			let duplicateProductCartExists = results[0].products.find(product => tools.isProductsEqual(product, coffee));

			if (duplicateProductCartExists !== undefined) {
				Cart.updateOne(
					{ 
						user_id: req.body.user_id,
						'products._id': duplicateProductCartExists._id
					},
					{
						$inc: { 'products.$.qty': 1}
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
								'success': true,
								'msg': 'Έχει προστεθεί ήδη στο καλάθι'
							});			
						}
					}
				);
			}
			else {
				Cart.updateOne(
					{ user_id: req.body.user_id }, 
					{ $push: { products: [ coffee ] }}, 
					(error, results) => {
						if (error) {
							res.send({ 'error': 'An unexpected error occured' });
							console.log(error);
						}
	
						if (results) {
							res.send({ 
								'success': true,
								'msg': 'Προστέθηκε στο καλάθι'
							});			
						}
					}
				);
			}
		}
	});
});

router.post('/inc', verifyToken, CartOperationsRules(), validate, (req, res) => {
	Cart.findOneAndUpdate(
		{ 
			user_id: req.body.user_id,
			'products._id': req.body.product_id
		},
		{
			$inc: { 'products.$.qty': 1}
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

router.post('/dec', verifyToken, CartOperationsRules(), validate, (req, res) => {
	Cart.findOneAndUpdate(
		{ 
			user_id: req.body.user_id,
			'products._id': req.body.product_id,
			'products.qty': { $gt: 1 }
		},
		{
			$inc: { 'products.$.qty': -1}
		},
		(error, results) => {
			if (error) {
				res.send({ 'error': 'An unexpected error occured' });
				console.log(error);
			}

			if (results) {
				res.send({ 'ok': true });			
			}
			else {
				res.send({ 'error': 'Δε μπορείτε να έχετε ποσότητα μικρότερη του ενός' });
			}
		}
	);
});

router.post('/del', verifyToken, CartOperationsRules(), validate, (req, res) => {
	Cart.findOneAndUpdate(
		{ 
			user_id: req.body.user_id,
		},
		{
			"$pull": { "products": { "_id": req.body.product_id }}
		},
		(error, results) => {
			if (error) {
				res.send({ 'error': 'An unexpected error occured' });
				console.log(error);
			}

			if (results) {
				res.send({ 
					'ok': true,
					'msg': 'Αφαιρέθηκε από το καλάθι'
				});			
			}
			else {
				res.send({ 'error': '' });
			}
		}
	);
});

router.post('/reorder', verifyToken, reorderSanitizeRules(), validate , (req, res) => {
	
});

module.exports = router;