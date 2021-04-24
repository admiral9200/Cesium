const express = require('express');
const db = require('../utils/db.config');
const { subscribeRule, validate } = require('../middleware/sanitizer');

const router = express.Router();

router.post('/subscribe', subscribeRule(), validate, (req, res) => {
	const queryToCheckDuplicateEmail = 'SELECT email FROM cc_newsletter WHERE email = ?';

	db.execute(queryToCheckDuplicateEmail, [req.body.email], (error, results) => {
		if (results.length > 0) {
			res.send({ 'error': 'Έχεις εγγραφεί ήδη στο newsletter'});
		}
		else {
			const queryToSubscribeEmail = 'INSERT INTO cc_newsletter (email) VALUES (?)';

			db.execute(queryToSubscribeEmail, [req.body.email], (error, results) => {
				if (error) res.status(500).send({ 'error': error });

				res.send({'status': true});
			});
		}
	});
});

module.exports = router;