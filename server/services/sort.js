const { contains } = require('../libs/functions');
const Cart = require('../models/cart');

const pricesSum = (user, stores) => {
	Cart.findOne({ user_id: user.id }, (error, results) => {
		if (error) {
			res.send({ 
				'error': error 
			});
		}
		let a = [];  
		if (results !== null) {
			results.products.forEach(cartProduct => {
				stores.forEach(store => {
					for (const menuProduct of store.menu) {
						if (contains(menuProduct, cartProduct)) {
							console.log('-----------------------------');
							console.log(menuProduct);
							console.log(cartProduct);
							console.log('-----------------------------');
						}
					}
				});
			});
		}
	});
};

module.exports = {
	pricesSum
};