const mongoose = require('mongoose');

const MerchantsSchema = new mongoose.Schema({
	username: {
		type: String,
		required: true,
	},
	password: {
		type: String,
		required: true,
	},
	dateCreated: {
		type: Date,
		required: true,
	},
	name: String,
	location: String,
	logo: String,
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
});

module.exports = mongoose.model('Merchants', MerchantsSchema);