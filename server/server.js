require('dotenv').config();

const express = require('express');
const cors = require('cors');
const mongoose = require('mongoose');
const http = require('http');
const socketio = require('socket.io');

const app = express();
const server = http.createServer(app);
const io = socketio(server);
const port = 3000;

const whitelist = [
	"http://localhost:8080",
	"http://localhost:8081",
	"http://192.168.1.9:8080",
	"http://192.168.1.6:8080",
	"http://192.168.137.1:8080",
];

let corsOptions = {
	origin: function (origin, callback) {
		if (whitelist.indexOf(origin) !== -1) {
			callback(null, true);
		} else {
			callback('Not allowed by CORS');
		}
	}
};

// MongoDB connection
mongoose.connect(process.env.MONGO_URL, {
	useNewUrlParser: true,
	useUnifiedTopology: true,
	useCreateIndex: true,
	useFindAndModify: false
})
.then(() => {
	console.log("Cofy Mongo connected...");
})
.catch(() => {
	console.error("Error in connecting");
});

app.disable('x-powered-by');

app.use(cors(corsOptions));
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

//ROUTES CLIENT
app.use('/auth' , require('./routes/client/auth'));
app.use('/user' , require('./routes/client/user'));
app.use('/order' , require('./routes/client/order'));
app.use('/stores' , require('./routes/client/stores'));
app.use('/checkout' , require('./routes/client/checkout'));
app.use('/home' , require('./routes/client/home'));
app.use('/profile', require('./routes/client/profile'));

//ROUTES MERCHANTS
app.use('/m/auth', require('./routes/merchants/auth'));
app.use('/m/user', require('./routes/merchants/user'));

io.on("connection", (socket) => {
	socket.on("order", (order) => {
		console.log(order);
	});

	//socket.disconnect(true);
});

server.listen(port, () => {
	console.log(`Cofy Backend running on port ${ port }`);
});