const mongoose = require('mongoose');

const UserSchema = new mongoose.Schema({
	email: {
		type: String,
		unique: true,
		required: true,
		trim: true
	},
	password: {
		type: String,
		required: true,
	},
	firstName: {
		type: String,
		required: true,
	},
	lastName: {
		type: String,
		required: true,
	},
	mobile: {
		type: String,
	},
	dateCreated: {
		type: Date,
		required: true
	},
	addresses: [{
		country: String,
		latitude: Number,
		longitude: Number,
		locality: String,
		postal_code: String,
		route: String,
		street_number: String
	}],
	orders: [{
		store_id: {
			type: String,
		},
		date: Date,
		payment: {
			type: String,
		},
		doorname: {
			type: String,
		},
		floor: {
			type: String,
		},
		phone: {
			type: String,
		},
		comment: String,
		products: [{
			name: {
				type: String,
			},
			price: {
				type: Number,
			},
			blends: {
				type: Array,
			},
			adds: {
				type: Array,
			},
			size: {
				type: Array,
			},
			extras: {
				type: Array,
			},
			decaf: {
				type: Boolean,
			},
			qty: {
				type: Number,
			}
		}]
	}]
}, 
{
	collection: "users"
});

module.exports = mongoose.model('User', UserSchema);