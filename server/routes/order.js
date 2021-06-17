const express = require('express');
const db = require('../utils/db.config');
const { reorderSanitizeRules, cartSanitizeRules , validate } = require('../middleware/sanitizer');
const verifyToken = require('../middleware/verifyToken');
const Coffee = require('../models/coffee');
const Cart = require('../models/cart');
const jwt_decode = require('jwt-decode');

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

router.get('/cart', verifyToken, (req, res) => {
	const user = jwt_decode(req.headers.authorization);

	Cart.find({ user_id: user.id }, (error, results) => {
		if (error) {
			res.send({ 'error': error });
		}
		else {
			res.send({ 'cart': results[0].products });
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
					extras: req.body.c_extras
				}]
			});

			cart.save()
			.then(doc => res.send({ 
				'success': true,
				'msg': 'Προστέθηκε στο καλάθι'
			}))
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
				extras: req.body.c_extras
			};
		}
	});
});

router.post('/reorder', verifyToken, reorderSanitizeRules(), validate , (req, res) => {
	let sqlQueryToOrderAgain = 'SELECT * FROM cc_orders_products WHERE id= ?';

	db.execute(sqlQueryToOrderAgain , [req.body.id] , (error, results) => {
		if (error) res.status(500).send({ error });

		if (results) {
			res.send({ 'status': true });
		}
	});
});

module.exports = router;