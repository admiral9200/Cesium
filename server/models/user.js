const mongoose = require('mongoose');

const UserSchema = new mongoose.Schema({
	email: String,
	password: String,
	firstName: String,
	lastName: String,
	mobile: String,
	adresses: [{
		address: String,
		floor: String,
		ringbell: String,
		selected: Boolean
	}],
	orders: [{
		store_id: String,
		date: Date,
		payment: String,
		doorname: Mixed,
		floor: Mixed,
		phone: String,
		comment: String,
		products: [{
			name: String,
			price: Number,	
			blends: Array,
			adds: Array,
			size: Array,
			extras: Array,
			decaf: Boolean,
			qty: Number
		}]
	}]
});

module.exports = mongoose.model('User', UserSchema);