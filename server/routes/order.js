const express = require('express');
const db = require('../utils/db.config');
const { reorderSanitizeRules, cartSanitizeRules , validate } = require('../middleware/sanitizer');
const verifyToken = require('../middleware/verifyToken');
const Coffee = require('../models/coffee');
const Cart = require('../models/cart');

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
	let coffees = [
		
	];
	
	const cart = new Cart({
		dateCreated: new Date(),
		user_id: req.body.user_id,
		products: [{ 
			id: Number,
			name: String,
			sugar: String,
			sugarType: String,
			blends: Array,
			size: Number,
			adds: Array,
			extras: Array
		}]
	});

	cart.save()
	.then(doc => {
		res.send({ 'status': true });
	})
	.catch(err => {
		res.send({ 'error': err});
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