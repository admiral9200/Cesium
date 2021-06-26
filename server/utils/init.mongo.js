const mongoose = require('mongoose');

mongoose.connect('mongodb://localhost:27017/cofy', {
	useNewUrlParser: true,
	useUnifiedTopology: true,
	useCreateIndex: true,
	useFindAndModify: false
})
.then(() => {
	let MerchantsSchema = new mongoose.Schema({
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

	const CoffeeSchema = new mongoose.Schema({
		name: String,
		price: Number,	
		blends: Array,
		adds: Array,
		size: Array,
		extras: Array,
		decaf: Boolean
	});
	
	let Merchants = mongoose.model('Merchants', MerchantsSchema);
	let Coffees = mongoose.model('Coffees', CoffeeSchema);

	new Coffees({
		name: 'Espresso',
		price: 1.30,
		decaf: true,
		blends: [
			'Fine Brazilian blend',
			'100% Superior Arabica'
		],
		adds: [
			'Γάλα'
		],
		size: [
			1
		],
		extras: [
			'Σιρόπι σοκολάτα'
		]
	}).save().then(doc => console.log("COFFEE SAVED IN DB")).catch(err => console.log(err));
	new Coffees({
		name: 'Cappuccino',
		price: 1.70,
		decaf: true,
		blends: [
			'Fine Brazilian blend',
			'100% Superior Arabica'
		],
		adds: [
			'Γάλα',
			'Κανέλα',
		],
		size: [
			1,
			2,
			3,
			4,
			5
		],
		extras: [
			'Σιρόπι σοκολάτα',
			'Σαντιγυ'
		]
	}).save().then(doc => console.log("COFFEE SAVED IN DB")).catch(err => console.log(err));

	new Coffees({
		name: 'Cappucino Latte',
		price: 1.70,
		decaf: true,
		blends: [
			'Fine Brazilian blend',
			'100% Superior Arabica'
		],
		adds: [
			'Γάλα',
			'Κανέλα',
			'Σοκολατα'
		],
		size: [
			1,
			2,
			3,
			4,
			5
		],
		extras: [
			'Σιρόπι σοκολάτα'
		]
	}).save().then(doc => console.log("COFFEE SAVED IN DB")).catch(err => console.log(err));

	new Coffees({
		name: 'Freddo Cappuccino',
		price: 1.70,
		decaf: true,
		blends: [
			'Fine Brazilian blend',
			'100% Superior Arabica'
		],
		adds: [
			'Γάλα',
			'Κανέλα',
			'Σοκολατα'
		],
		size: [
			1,
			2,
			3,
			4,
			5
		],
		extras: [
			'Σιρόπι σοκολάτα'
		]
	}).save().then(doc => console.log("COFFEE SAVED IN DB")).catch(err => console.log(err));
	
	/* let data = new Merchants({
			dateCreated: new Date(),
			name: 'Veribet',
			location: '06 Russell Point',
			logo: 'https://picsum.photos/200',
			menu: [
				{
					name: 'Espresso',
					price: 1.50,
					blends: [],
					adds: [
						'Γάλα'
					],
					size: [
						1,
						2,
						3,
					],
					decaf: true
				},
				{
					name: 'Cappuccino',
					price: 1.50,
					blends: [
						'Fine Brazilian blend',
						'100% Superior Arabica'
					],
					adds: [
						'Κανέλα',
						'Σκόνη Σοκολάτας'
					],
					size: [
						1,
						2,
						3,
						4,
						5
					],
					decaf: true
				},
				{
					name: 'Cappucino Latte',
					price: 1.70,
					decaf: true,
					blends: [
						'Fine Brazilian blend',
						'100% Superior Arabica'
					],
					adds: [
						'Γάλα',
						'Κανέλα',
					],
					size: [
						1,
						2
					],
					extras: [
						'Σιρόπι σοκολάτα'
					]
				},
				{
					name: 'Freddo Cappucino',
					price: 1.80,
					decaf: true,
					blends: [],
					adds: [
						'Γάλα',
						'Κανέλα',
						'Σκόνη Σοκολάτας'
					],
					size: [
						1,
						2,
						3,
						4,
						5
					],
					extras: [
						'Σιρόπι σοκολάτα'
					]
				},
			]
		},
	); */
	
	//data.save().then(doc => console.log(doc)).catch(err => console.log(err));
})
.catch(() => {
	console.error("Error in connecting");
});