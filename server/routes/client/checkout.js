const express = require('express');
const rethink = require('rethinkdb');
const jwt_decode = require('jwt-decode');
// const { validate, PaymentCheckoutRules } = require('../../middleware/sanitizer');
const verifyToken = require('../../middleware/verifyToken');
const uniqid = require('uniqid');

const Cart = require('../../models/cart');
const Merchants = require('../../models/merchant');

const router = express.Router();

const PORT = 49154;

router.post('/sendorder', verifyToken, async (req, res) => {
	let order = req.body.order;

	try {
		
		order.id = uniqid.time('CC');
		order.date = new Date().toLocaleString('en-GB', {
			timeZone: 'Europe/Athens'
		});
		order.confirmed = false;
		order.completed = false;
		order.cancelled = false;
		order.cancelledReason = "";
		order.loaderInCard = false;

		rethink.connect({
			host: 'localhost',
			port: PORT,
			db: 'CC_Orders',
		}, (error, conn) => {
			if (error) throw error;

			rethink.table('orders')
			.insert(order)
			.run(conn, (err, result) => {
				if (err) throw err;

				if (result.inserted) {
					res.send({
						'sent_success': true,
						'order_id': order.id
					});
				}
				else {
					res.send({
						'error': "Order could not sent. Try again."
					});
				}
			});
		});
	} 
	catch (error) {
		//! LOG ERROR
		console.log(error);
		res.send({
			'error': "An unexpected error occured"
		});
	}
});

router.get('/cart', verifyToken, (req, res) => {
	const user = jwt_decode(req.headers.authorization);

	try {
		Cart.find({ user_id: user.id }, async (error, results) => {
			if (error) throw error;
	
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
									'price': storeProduct.price,
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
		});	
	} 
	catch (error) {
		//! LOG ERROR
		console.log(error);
		res.send({
			'error': "An unexpected error occured"
		});
	}
});

module.exports = router;