const express = require('express');
const {  } = require('../middleware/sanitizer');
const verifyToken = require('../middleware/verifyToken');
const Merchants = require('../models/merchant');

const router = express.Router();

router.get('/merchants', verifyToken, (req, res) => {
	Merchants.find({}, (error, stores) => {
		if (error) {
			res.send({ 'error': error });
		}
		
		res.send({ 'stores': stores });
	});
});

module.exports = router;