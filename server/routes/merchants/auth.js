const express = require('express');
const bcrypt = require('bcrypt');
const jwt = require('jsonwebtoken');
const { loginMerchantRule, validate } = require('../../middleware/sanitizer');
const cert = require('../../utils/jwt.config');
const Merchant = require('../../models/merchant');

const router = express.Router();

router.post('/login', loginMerchantRule(), validate, (req, res) => {
	Merchant.findOne({ username: req.body.username }, (error, results) => {
		if (error) {
			res.send({
				'error': 'An unexpected error occured' 
			});
		}

		if (results !== null) {
			bcrypt.compare(req.body.password, results.password, (error, result) => {
				if (error) {
					res.send({ 
						'error': 'An internal error occured' 
					});
				}

				if (result){
					jwt.sign({ 
						email: results.email, 
						id: results._id 
					}, cert.secret,
					{
						algorithm: 'RS256',
						expiresIn: '2h' // ! 2 hours for testing
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
				else {
					res.send({ 
						'error': 'Username or password is incorrect' 
					});
				}
			});
		}
		else {
			res.send({ 
				'error': 'Username or password is incorrect' 
			});
		}
	});
});

module.exports = router;