const express = require('express');
const jwt_decode = require('jwt-decode');
const { validate, PaymentCheckoutRules } = require('../../middleware/sanitizer');
const verifyToken = require('../../middleware/verifyToken');
const rethinkdb = require('rethinkdb');

const Cart = require('../../models/cart');
const Merchants = require('../../models/merchant');

const router = express.Router();

let rethinkConnection = null;

router.post('/order', verifyToken, PaymentCheckoutRules(), validate, async (res, req) => {
	//RethinkDB connection
	let rethinkConnection = await rethinkdb.connect({
		host: 'localhost',
		port: 49154,
		db: 'CC_Orders'
	},);

	// TODO integrate paypal and stripe apis
});

router.get('/cart', verifyToken, (req, res) => {
	const user = jwt_decode(req.headers.authorization);

	Cart.find({ user_id: user.id }, async (error, results) => {
		if (error) {
			res.send({ 
				'error': error 
			});
		}
		else {
			if (results.length > 0) {
				if (results[0].store_id) {

					let store = await Merchants.findOne({ 
						_id: results[0].store_id 
					})
					.exec();

					if (store !== null) {
						let sum = 0, cart = [];
						let cartProducts = results[0].products;

						cartProducts.forEach(product => {
							const storeProduct = store.menu.find(p => p.name === product.name);

							if (storeProduct !== undefined) {
								cart.push({
									'price': storeProduct.price.toFixed(2).replace('.', ','),
									'adds': product.adds,
									'extras': product.extras,
									'qty': product.qty,
									'_id': product._id,
									'name': product.name,
									'sugar': product.sugar,
									'sugarType': product.sugarType,
									'blends': product.blends,
									'decaf': product.decaf,
								});
								// * Known object properties used here, maybe it can be dynamic
							}

							sum += storeProduct.price;
						});

						res.send({
							'cart': cart,
							'sum': sum
						});
					}
					else {
						res.send({ 
							'cart': [],
							'sum' : null,
							'msg': 'Το καλάθι σου είναι άδειο'
						});
					}
				}
			}
			else {
				res.send({ 
					'cart': [],
					'sum' : null,
					'msg': 'Το καλάθι σου είναι άδειο'
				});
			}
		}
	});
});

module.exports = router;