module.exports = {
	isProductsEqual: function (product1, product2) {
		return product1.name === product2.name && 
			product1.size === product2.size && 
			product1.sugar === product2.sugar && 
			product1.sugarType === product2.sugarType && 
			product1.blends === product2.blends && 
			product1.decaf === product2.decaf && 
			this.arrayEquals(product1.adds, product2.adds) && 
			this.arrayEquals(product1.extras, product2.extras);
	},

	arrayEquals: function (a, b) {
		return Array.isArray(a) &&
			Array.isArray(b) &&
			a.length === b.length &&
			a.every((val, index) => val === b[index]);
	}
};