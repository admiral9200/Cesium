const express = require('express');
const verifyToken = require('../../middleware/verifyToken');
const jwt_decode = require('jwt-decode');
const rethink = require('rethinkdb');
const Merchant = require('../../models/merchant');

const PORT = 49154;

const router = express.Router();

router.post('/confirm', verifyToken, async (req, res) => {
	try {
		const user = jwt_decode(req.headers.authorization);
		
		const merchant = await Merchant.findOne({ 
			_id: user.id
		});

		if (merchant) {
			rethink.connect({
				host: 'localhost',
				port: PORT,
				db: 'CC_Orders'
			}, (error, conn) => {
				if (error) {
					throw error;
				}
				else {
					rethink.table('orders')
					.filter(rethink.row("id").eq(req.body.order))
					.update({ confirmed: true })
					.run(conn, (error, confirmedOrder) => {
						if (error) {
							//! LOG DB ERRORS
							throw error;
						}

						if (confirmedOrder.replaced || confirmedOrder.unchanged) {
							res.send({
								'confirmed': true
							});
						}
						else {
							res.send({
								'error': 'Order did not confirmed. Try again.'
							});
						}
					});
				}
			});
		}
	} 
	catch (error) {
		res.send({
			'error': "An error occured"
		});
	}
});

router.post('/deliver', verifyToken, async (req, res) => {
	try {
		const user = jwt_decode(req.headers.authorization);
		
		const merchant = await Merchant.findOne({ 
			_id: user.id
		});

		if (merchant) {
			rethink.connect({
				host: 'localhost',
				port: PORT,
				db: 'CC_Orders'
			}, (err, conn) => {
				if (err) {
					res.send({
						//! LOG ERROR FROM DB
						error: {
							msg: 'An unexpected error occured'
						}
					});
				}
				else {
					rethink.table('orders')
					.filter(rethink.row("id").eq(req.body.order))
					.filter(rethink.row("confirmed").eq(true))
					.update({ completed: true })
					.run(conn, (err, completedOrder) => {
						if (err) {
							//! LOG DB ERRORS
							res.send({
								'error': "An error occured"
							});
						}

						if (completedOrder.replaced || completedOrder.unchanged) {
							res.send({
								'completed': true
							});
						}
						else {
							res.send({
								'error': "Order did not completed. Check that you first confirmed the order and try again."
							});
						}
					});
				}
			});
		}
	} 
	catch (error) {
		//! LOG ERRORS
		res.send({
			error: {
				msg: 'An unexpected error occured'
			}
		});
	}
});

router.post('/cancel', verifyToken, async (req, res) => {
	if (req.body.cancel_reason !== '') {
		try {
			const user = jwt_decode(req.headers.authorization);
			
			const merchant = await Merchant.findOne({ 
				_id: user.id
			});
	
			if (merchant) {
				rethink.connect({
					host: 'localhost',
					port: PORT,
					db: 'CC_Orders'
				}, (err, conn) => {
					if (err) {
						res.send({
							//! LOG ERROR FROM DB
							error: {
								msg: 'An unexpected error occured'
							}
						});
					}
					else {
						rethink.table('orders')
						.filter(rethink.row("id").eq(req.body.order))
						.update({ 
							cancelled: true,
							cancelledReason: req.body.cancel_reason
						})
						.run(conn, (err, cancelledOrder) => {
							if (err) {
								//! LOG DB ERRORS
								res.send({
									'error': "An error occured"
								});
							}
	
							if (cancelledOrder.replaced || cancelledOrder.unchanged) {
								res.send({
									'cancelled': true
								});
							}
							else {
								res.send({
									'error': "Order did not completed. Check that you first confirmed the order and try again."
								});
							}
						});
					}
				});
			}
		} 
		catch (error) {
			//! LOG ERRORS
			res.send({
				error: {
					msg: 'An unexpected error occured'
				}
			});
		}
	}
	else {
		res.send({
			error: {
				type: 'NoCancelReason',
				msg: 'A reason is required to cancel an order.'
			}
		});
	}
});

module.exports = router;