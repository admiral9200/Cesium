const express = require('express');
const cors = require('cors');

const app = express();

const port = 3000;

const whitelist = [
	"http://localhost:8081", 
	"http://localhost:8082", 
	"http://192.168.1.3:8081",
	"http://192.168.1.3:8082",
	"http://192.168.1.3:3000",
	"http://localhost:3000",
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

app.use(cors(corsOptions));

app.use(express.json());
app.use(express.urlencoded({ extended: false }));

app.use('/auth' , require('./routes/auth'));

app.use('/order' , require('./routes/order'));

app.use('/home' , require('./routes/home'));

app.use('/profile', require('./routes/profile'));

app.listen(port, () => {
	console.log(`Chip Coffee Backend running on port ${ port }`);
});