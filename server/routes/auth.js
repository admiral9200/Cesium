const express = require('express');
const bcrypt = require('bcrypt');
const jwt = require('jsonwebtoken');
const db = require('../utils/db.config');
const { loginSanitizeRules, signupSanitizeRules, validate } = require('../middleware/sanitizer');
const config = require('../utils/jwt.config');
const verifyToken = require('../middleware/verifyToken');
const jwt_decode = require('jwt-decode');

const router = express.Router();

router.post('/login', loginSanitizeRules(), validate, (req, res) => {
	let sqlUser = 'SELECT * FROM cc_users WHERE email = ?';
	
	db.execute(sqlUser, [req.body.email], (error, results) => {
		if (error) {
			res.status(500).send({'error': error });
		}
		
		try {
			if (results.length > 0) {
				(async (data) => {
					await bcrypt.compare(data, results[0].password, (error, result) => {
						if (error) {
							res.status(500).send({ error: 'An internal error occured' });
						}
	
						if (result){
							const token = jwt.sign({ email: results[0].email, id: results[0].id }, config.secret, { expiresIn: 1600 }); //low seconds for testing
	
							res.send({ auth: true, token: token });
						}
						else {
							res.send({ 'error': 'Το email ή ο κωδικός που έχεις εισάγει είναι λάθος!' });
						}
					});
				})(req.body.password);
			}
			else {
				res.send({ 'error': 'Το email ή ο κωδικός που έχεις εισάγει είναι λάθος!' });
			}	
		} 
		catch (error) {
			res.status(500).send({ error: 'An unexpected error occured. Try again' + error });
		}
	});
});

router.post('/signup', signupSanitizeRules(), validate, (req, res) => {
	let sqlQueryIfUserExists = 'SELECT email FROM cc_users WHERE email = ?';

	const email = req.body.email;
	const name = req.body.name;
	const surname = req.body.surname;
	const mobile = req.body.mobile;

	if (req.body.password === req.body.passwordConfirm) {
		db.execute(sqlQueryIfUserExists, [email], (error, results) => {
			if (error) {
				res.status(500).send({'error': error });
			}
			
			if (results.length > 0) {
				res.send({ 'error': 'Το email αυτό υπάρχει ήδη!' });
			}
			else {
				let queryToAddUser = 'INSERT INTO cc_users (email, password, firstName, lastName, mobile) VALUES(? , ? , ? , ? , ?)';

				(async (pass) => {
					await bcrypt.hash(pass, saltRounds = 10, (error, encrypted) => {
						if (error) res.status(500).send({ 'error': 'An error occured' });

						db.execute(queryToAddUser, [email, encrypted, name, surname, mobile], (error, results) => {
							if (error) res.status(500).send({ 'error': 'An internal Database error occured. Try again' });
							
							if (results) {
								res.send({ 'status': 'ok' });
							}
						});
					});
				})(req.body.password);
			}
		});
	}
	else {
		res.send(JSON.stringify({
			'error': 'Passwords do not match'
		}));
	}
});

router.get('/user', verifyToken, (req, res) => {
	let queryToGetUserDetails = 'SELECT firstName, lastName, email, mobile FROM cc_users WHERE id = ?';

	const user = jwt_decode(req.headers['authorization']);

	db.execute(queryToGetUserDetails, [user.id], (error, results) => {
		if (error) res.status(500).send({'error': error });

		if (results.length > 0) {
			res.send({ 
				name: results[0].firstName, 
				surname: results[0].lastName, 
				email: results[0].email, 
				mobile: results[0].mobile 
			});
		}
	});
});

router.post('/logout' , (req, res) => {
	res.send({ auth: false });
});

module.exports = router;