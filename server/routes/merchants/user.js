const express = require('express');
const verifyToken = require('../../middleware/verifyToken');
const jwt_decode = require('jwt-decode');
const Merchant = require('../../models/merchant');

const router = express.Router();

router.get('/info', verifyToken, async (req, res) => {
	const user = jwt_decode(req.headers.authorization);
	try {
		const merch = await Merchant.findOne({ 
			_id: user.id, 
			username: user.username 
		});

		if (merch !== null) {
			res.send({ 
				'merchant': merch 
			});
		}
		else {
			res.send({
				'error': 'User does not exist' 
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

module.exports = router;