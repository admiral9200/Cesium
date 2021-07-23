const { contains } = require('../libs/functions');
const Cart = require('../models/cart');

const pricesSum = async (user, stores) => {
	let resolvedStores = [];
	
	try {
		let cartProducts = await Cart.findOne({ user_id: user.id });

		if (cartProducts !== null) {
			stores.forEach(store => {

				let helperLength = 0;

				for (const cartProduct of cartProducts.products) {	
					for (const menuProduct of store.menu) {
						if (contains(menuProduct, cartProduct)) {
							helperLength++;
							break;
						}
					}
				}

				if (helperLength === cartProducts.products.length) {
					resolvedStores.push(store);
				}
			});

			return resolvedStores;
		}
	} 
	catch (error) {
		res.send({ 
			'error': error 
		});
	}
};

module.exports = {
	pricesSum
};