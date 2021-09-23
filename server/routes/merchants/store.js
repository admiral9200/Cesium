const express = require('express');
const verifyToken = require('../../middleware/verifyToken');
const jwt_decode = require('jwt-decode');
const rethink = require('rethinkdb');

const Merchant = require('../../models/merchant');

const router = express.Router();

const PORT = 49154;

router.post('/status', verifyToken, async (req, res) => {
	try {
		const user = jwt_decode(req.headers.authorization);

		const merchant = await Merchant.findOne({ 
			_id: user.id
		});

		if (merchant) {
			const storeStatusUpdated = await Merchant.updateOne({
				_id: merchant._id
			},
			{
				"$set": {
					"store_status": !merchant.store_status
				}
			},
			{
				new: true
			});

			if (storeStatusUpdated.ok && storeStatusUpdated.nModified === 1) {
				res.send({
					status_changed: true,
					store_status: !merchant.store_status
				});
			}
			else {
				res.send({
					error: {
						msg: 'There was an error in your request. Try again'
					}
				});
			}
		}
	} 
	catch (error) {
		// * Log error to file
		console.log(error);
		res.send({
			error: {
				msg: 'An unexpected error occured'
			}
		});
	}
});

router.get('/feed', verifyToken, (req, res) => {
	const merchant = jwt_decode(req.headers.authorization);

	rethink.connect({
		host: 'localhost',
		port: PORT,
		db: 'CC_Orders',
	}, (error, conn) => {
		if (error) {
			throw error;
		}

		rethink.table('orders')
		.filter(rethink.row("store")("_id").eq(merchant.id))
		.run(conn , function(err, cursor) {
			if (err) throw err;
			cursor.toArray(function(err, result) {
				if (err) throw err;

				if (result.length > 0) {
					res.send({
						new_orders: result
					});
				}
				else {
					res.send({
						no_new_orders: true
					});
				}
			});
		});	
	});
});

module.exports = router;