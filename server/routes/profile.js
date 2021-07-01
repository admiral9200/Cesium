const express = require('express');
const bcrypt = require('bcrypt');
const { profileInfoRules, profileCredentialsRules , validate } = require('../middleware/sanitizer');
const verifyToken = require('../middleware/verifyToken');
const jwt_decode = require('jwt-decode');
const User = require('../models/user');

const router = express.Router();

router.post('/info', profileInfoRules(), validate, verifyToken, (req, res) => {
	const user = jwt_decode(req.headers.authorization);

	User.findOneAndUpdate({ _id: user.id, email: user.email },{
		firstName: req.body.name,
		lastName: req.body.surname,
	},
	{
		new: true
	},
	(error, results) => {
		if (error) {
			res.send({
				'error': 'An unexpected error occured' 
			});
		}

		if (results) {
			res.send({ 
				'completed': true 
			});
		}
		else {
			res.send({ 
				'error': 'An unexpected error occured'
			});
		}
	});
});

router.post('/credentials', profileCredentialsRules(), validate, verifyToken, (req, res) => {
	const user = jwt_decode(req.headers.authorization);

	User.findOne({ _id: user.id, email: user.email }, async (error, results) => {
		if (error) {
			res.send({
				'error': error 
			});
		}

		if (results.password) {
			try {	
				const comparedHashes = await bcrypt.compare(req.body.oldpass, results.password);

				if (comparedHashes) {
					const hashed = await bcrypt.hash(req.body.newpass, 10);

					if (hashed) {
						User.findOneAndUpdate({ _id: user.id, email: user.email },{
							password: hashed
						},
						{
							new: true
						},
						(err, newPass) => {
							if (err) {
								res.send({ 
									'error': 'An internal error occured' 
								});
							}

							if (newPass.password !== results.password) {
								res.send({ 
									'completed': true,
									'msg': 'Ο κωδικός σου άλλαξε με επιτυχία'
								});
							}
						});
					}
				}
				else {
					res.send({ 
						'error': 'Ο παλαιός κωδικός είναι λάθος' 
					});
				}
			} 
			catch (error) {
				res.send({ 
					'error': 'An internal error occured' 
				});	
			}
		}
	});
});

router.get('/delete', verifyToken, async (req, res) => {
	const user = jwt_decode(req.headers.authorization);

	const userDeleted = await User.deleteOne({ _id: user.id });

	if (userDeleted.ok === 1) {
		res.send({ 
			'deleted': true 
		});
	}
	else {
		res.send({ 
			'error': 'An internal error occured' 
		});	
	}
});

module.exports = router;