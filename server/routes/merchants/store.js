const express = require('express');
const verifyToken = require('../../middleware/verifyToken');
const jwt_decode = require('jwt-decode');

const Merchant = require('../../models/merchant');

const router = express.Router();

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
		res.send({
			'error': 'An unexpected error occured' 
		});
	}
});

module.exports = router;