const express = require('express');
const bcrypt = require('bcrypt');
const jwt = require('jsonwebtoken');
const { loginSanitizeRules, signupSanitizeRules, validate } = require('../../middleware/sanitizer');
const cert = require('../../utils/jwt.config');
const User = require('../../models/user');

const router = express.Router();

router.post('/login', loginSanitizeRules(), validate, (req, res) => {
	User.findOne({ email: req.body.email }, (error, results) => {
		if (error) {
			console.log(error);
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
						expiresIn: '5h' // ! 2 hours for testing
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
						'error': 'Το email ή ο κωδικός που έχεις εισάγει είναι λάθος!' 
					});
				}
			});
		}
		else {
			res.send({ 
				'error': 'Το email ή ο κωδικός που έχεις εισάγει είναι λάθος!' 
			});
		}
	});
});

router.post('/register', signupSanitizeRules(), validate, (req, res) => {
	if (req.body.password === req.body.passwordConfirm) {
		User.findOne({ email: req.body.email }, (error, results) => {
			if (error) {
				res.send({'error': error });
			}

			if (results) {
				res.send({ 
					'error': 'Το email αυτό υπάρχει ήδη!' 
				});
			}
			else {
				bcrypt.hash(req.body.password, saltRounds = 10, async (error, encrypted) => {
					if (error) {
						res.send({ 
							'error': 'An error occured' 
						});
					}
					try {
						const user = new User({
							email: req.body.email,
							password: encrypted,
							firstName: req.body.name,
							lastName: req.body.surname,
							dateCreated: new Date(),
							adresses: [],
							orders: []
						});

						const userSaved = await user.save();

						if (userSaved) {
							res.send({ 
								'status': 'OK' 
							});
						}	
					} 
					catch (error) {
						console.log(error);
						res.send({ 
							'error': 'An internal Database error occured. Try again' 
						});
					}
				});
			}
		});
	}
	else {
		res.send(JSON.stringify({
			'error': 'Passwords do not match'
		}));
	}
});

router.post('/logout' , (req, res) => {
	res.send({ auth: false });
});

module.exports = router;