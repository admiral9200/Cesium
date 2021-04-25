const express = require('express');
const db = require('../utils/db.config');
const { reorderSanitizeRules , validate } = require('../middleware/sanitizer');
const verifyToken = require('../middleware/verifyToken');

const router = express.Router();

router.get('/coffees', verifyToken, (req, res) => {
	let sqlQueryToGetCoffees = 'SELECT * FROM cc_coffees';

	db.execute(sqlQueryToGetCoffees, (error, results) => {
		if (error) res.status(500).send({ error });

		try {
			if (results !== undefined) {
				res.send({ 'menu': results });
			}
		} 
		catch (error) {
			res.status(500).send({ 'error': error });
		}
	});
});

router.post('/reorder', verifyToken, reorderSanitizeRules(), validate , (req, res) => {
	let sqlQueryToOrderAgain = 'SELECT * FROM cc_orders_products WHERE id= ?';

	db.execute(sqlQueryToOrderAgain , [req.body.id] , (error, results) => {
		if (error) res.status(500).send({ error });

		res.send({ 'status': true});
	});
});

module.exports = router;