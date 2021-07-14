const mongoose = require('mongoose');

const MerchantsSchema = new mongoose.Schema({
	dateCreated: Date,
	name: String,
	location: String,
	logo: String,
	active_orders: Number,
	avg_order_preparation_min: Number,
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