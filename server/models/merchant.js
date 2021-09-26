const mongoose = require('mongoose');

const MerchantsSchema = new mongoose.Schema({
	username: {
		type: String,
		required: true,
	},
	password: {
		type: String,
		required: true,
		select: false
	},
	dateCreated: {
		type: Date,
		required: true,
	},
	name: String,
	location: String,
	logo: String,
	store_status: Boolean,
	active_orders: Number,
	avg_order_preparation: Number,
	open_hour: Date,
	menu: [{
		name: String,
		price: Number,	
		blends: Array,
		sugarType: Array,
		adds: Array,
		extras: Array,
		size: Array,
		decaf: Boolean
	}],
	orders: [{
		cancelled: Boolean,
		cancelledReason: String,
		cart: [{
			_id: String,
			adds: Array,
			blends: String,
			decaf: Boolean,
			extras: Array,
			name: String,
			price: Number,
			qty: Number,
			sugar: String,
			sugarType: String
		}],
		completed: Boolean,
		confirmed: Boolean,
		date: String,
		id: String,
		loaderInCard: Boolean,
		user: {
			address: {
				_id: String,
				country: String,
				latitude: Number,
				locality: String,
				longitude: Number,
				postal_code: String,
				route: String,
				street_number: String
			},
			comments: String,
			email: String,
			floor: String,
			id: String,
			name: String,
			payment: String,
			phone: String,
			ringbell: String,
			surname: String
		}
	}]
});

module.exports = mongoose.model('Merchants', MerchantsSchema);