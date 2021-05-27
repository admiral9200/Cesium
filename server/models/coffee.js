const mongoose = require('mongoose');

const CoffeeSchema = new mongoose.Schema({
	name: String,
	price: Number,	
	blends: Array,
	adds: Array,
	size: Array,
	extras: Array,
	decaf: Boolean
});

module.exports = mongoose.model('Coffees', CoffeeSchema);