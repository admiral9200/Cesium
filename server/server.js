const express = require('express');
const cors = require('cors');
const mongoose = require('mongoose');

const app = express();
const port = 3000;

const whitelist = [
	"http://localhost:8081", 
	"http://localhost:8082", 
	"http://192.168.1.3:8081",
	"http://192.168.1.3:8082",
	"http://192.168.1.3:3000",
];

var corsOptions = {
	origin: function (origin, callback) {
		if (whitelist.indexOf(origin) !== -1) {
			callback(null, true);
		} else {
			callback(new Error('Not allowed by CORS'));
		}
	}
};

mongoose.connect('mongodb://localhost:27017/cofy', {
	useNewUrlParser: true,
	useUnifiedTopology: true,
	useCreateIndex: true,
	useFindAndModify: false
})
.then(() => {
	console.log("Mongo Cofy connected...");
})
.catch(() => {
	console.error("Error in connecting");
});

app.disable('x-powered-by');

app.use(cors(corsOptions));

app.use(express.json());
app.use(express.urlencoded({ extended: true }));

//ROUTES
app.use('/auth' , require('./routes/auth'));

app.use('/user' , require('./routes/user'));

app.use('/order' , require('./routes/order'));

app.use('/stores' , require('./routes/stores'));

app.use('/home' , require('./routes/home'));

app.use('/profile', require('./routes/profile'));

app.listen(port, () => {
	console.log(`Chip Coffee Backend running on port ${ port }`);
});