const express = require('express');
const bcrypt = require('bcrypt');
const jwt = require('jsonwebtoken');
const { loginMerchantRule, validate } = require('../../middleware/sanitizer');
const cert = require('../../utils/jwt.config');
const Merchant = require('../../models/merchant');

const router = express.Router();

router.post('/login', loginMerchantRule(), validate, async (req, res) => {
	try {
		let merchant = await Merchant.findOne({ username: req.body.username }).select("+password");	

		if (merchant) {
			bcrypt.compare(req.body.password, merchant.password, (error, result) => {
				if (error) {
					console.log(error);
					res.send({ 
						'error': 'An internal error occured' 
					});
				}

				if (result){
					jwt.sign({ 
						username: merchant.username, 
						id: merchant._id 
					}, cert.secret,
					{
						algorithm: 'RS256',
						expiresIn: '1h' // ! 2 hours for testing
					}, (error, token) => {

						if (error) {
							res.send({ 
								'error': 'An unexpected error occured' 
							});
							console.log(error);
						}

						if (token) {
							res.send({ 
								auth: true, 
								token: token 
							});
						}
					});
				}
			});
		}
		else {
			res.send({
				error: {
					name: 'CredentialsIncorrect',
					msg: 'Username or Password is incorrect'
				}
			});
		}
	} 
	catch (error) {
		res.send({
			'error': 'An unexpected error occured' 
		});
	}
});

router.post('/logout' , (req, res) => {
	res.send({ auth: false });
});

module.exports = router;