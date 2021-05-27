const mongoose = require('mongoose');

const MerchantsSchema = new mongoose.Schema({
	dateCreated: Date,
	name: String,
	location: String,
	logo: String,
	menu: [{
		name: String,
		price: Number,	
		blends: Array,
		adds: Array,
		size: Array,
		decaf: Boolean
	}],
});

module.exports = mongoose.model('Merchants', MerchantsSchema);