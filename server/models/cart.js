const mongoose = require('mongoose');

const CartSchema = new mongoose.Schema({
	dateCreated: Date,
	user_id: Number,
	products: [{
		name: String,
		size: Number,
		sugar: String,
		sugarType: String,
		blends: Array,
		decaf: Boolean,
		adds: Array,
		extras: Array
	}]
});

module.exports = mongoose.model('Cart', CartSchema);