const express = require('express');
const db = require('../utils/db.config');
const bcrypt = require('bcrypt');
const { profileInfoRules, profileCredentialsRules , validate } = require('../middleware/sanitizer');
const verifyToken = require('../middleware/verifyToken');
const jwt_decode = require('jwt-decode');

const router = express.Router();

router.post('/info', profileInfoRules(), validate, verifyToken, (req, res) => {
	const queryToChangeUserInfo = 'UPDATE cc_users SET firstName = ?, lastName = ? WHERE id = ?';

	const user = jwt_decode(req.headers['authorization']);

	db.execute(queryToChangeUserInfo, [req.body.name, req.body.surname, user.id], (error, results) => {
		if (error) res.send({'error': error });

		if (results) res.send({ 'completed': true });
		else res.send({ 'error': 'An unexpected error occured'});
	});
});

router.post('/credentials', profileCredentialsRules(), validate, verifyToken, (req, res) => {
	const queryToFetchOldPass = 'SELECT password FROM cc_users WHERE id = ?';
	const queryToUpdatePassword = 'UPDATE cc_users SET password = ? WHERE id = ?';
	const user = jwt_decode(req.headers['authorization']);
	const newPass = req.body.newpass;
	const oldPass = req.body.oldpass;

	db.execute(queryToFetchOldPass, [user.id], (error, results) => {
		if (error) res.send({'error': error });

		try {
			if (results) {
				(async (oldPassword) => {
					await bcrypt.compare(oldPassword, results[0].password, (error, result) => {
						if (error) res.send({ 'error': 'An internal error occured' });
	
						if (result){
							bcrypt.hash(newPass, 10, (err, hash) => {
								if (err) res.send({ 'error': 'An error occured' });

								if (hash) {
									db.execute(queryToUpdatePassword, [hash, user.id], (error, results) => {
										if (error) res.send({ 'error': 'An internal Database error occured. Try again' });

										if (results) {
											res.send({ 'completed': true });
										}
									});
								}
							});
						}
						else {
							res.send({ 'error': 'Ο παλαιός κωδικός είναι λάθος' });
						}
					});
				})(oldPass);
			}
			else {
				res.send({ 'error': 'Ο παλαιός κωδικός είναι λάθος' });
			}	
		} 
		catch (error) {
			res.send({ error: 'An unexpected error occured. Try again' + error });
		}
	});
});

router.get('/delete', verifyToken, (req, res) => {
	const user = jwt_decode(req.headers['authorization']);
	const queryToDeleteUserAccount = 'DELETE cc_users, cc_address FROM cc_users users INNER JOIN cc_address addresses ON cc_users.id = cc_address.user_id WHERE cc_users.id = ?';

	db.execute(queryToDeleteUserAccount, [user.id], (error, result) => {
		if (error) res.send({ 'error': 'An internal Database error occured.' });

		if (result) {
			res.send({ 'deleted': true });
		}
	});
});

module.exports = router;