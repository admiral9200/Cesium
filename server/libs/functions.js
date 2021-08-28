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

	contains: function (base, tested) {
		if (!base.blends.includes(tested.blends)) {
			return false;
		}

		if (tested.adds.length > 0) {
			if (!base.adds.some(add => tested.adds.includes(add))) {
				return false;
			}
		}

		if (tested.extras.length > 0) {
			if (!base.extras.some(extra => tested.extras.includes(extra))) {
				return false;
			}
		}

		return base.name === tested.name &&
			base.sugarType.includes(tested.sugarType) &&
			base.size.includes(tested.size);
	},

	arrayEquals: function (a, b) {
		return Array.isArray(a) &&
			Array.isArray(b) &&
			a.length === b.length &&
			a.every((val, index) => val === b[index]);
	},

	duration_min: function(x) {
		return Number.parseFloat(x).toFixed(0);
	}
};