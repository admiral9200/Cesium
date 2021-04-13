const express = require('express');
const db = require('../utils/db.config');
const jwt = require('jsonwebtoken');
const { reorderSanitizeRules , validate } = require('../middleware/sanitizer');
const config = require('../utils/jwt.config');

const router = express.Router();

router.get('/coffees' , (req, res) => {
	let sqlQueryToGetCoffees = 'SELECT * FROM cc_coffees';

	db.execute(sqlQueryToGetCoffees, (error, results) => {
		if (error) {
			res.status(500).send({ error });
		}
		else {
			res.send(results);
		}
	});
});

router.post('/reorder' , reorderSanitizeRules(), validate , (req, res) => {
	let sqlQueryToOrderAgain = 'SELECT * FROM cc_orders_products WHERE id= ?';

	db.execute(sqlQueryToOrderAgain , [req.body.orderId] , (error, results) => {
		
	});
});

module.exports = router;