const mongoose = require('mongoose');

const CartSchema = new mongoose.Schema({
	dateCreated: Date,
	user_id: String,
	store_id: {
		type: String,
		default: ''
	},
	products: [{
		name: {
			type: String,
			required: true
		},
		size: {
			type: Number,
			required: true
		},
		sugar: {
			type: String,
			required: true
		},
		sugarType: {
			type: String,
			required: true
		},
		blends: {
			type: String
		},
		decaf: {
			type: Boolean
		},
		adds: {
			type: Array
		},
		extras: {
			type: Array
		},
		qty: {
			type: Number,
			default: 1
		}
	}]
});

module.exports = mongoose.model('Cart', CartSchema);