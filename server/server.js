require('dotenv').config();

const express = require('express');
const cors = require('cors');
const mongoose = require('mongoose');
const http = require('http');
const socketio = require('socket.io');
const registerOrderHandler = require('./services/orderHandler');

const jwt = require('jsonwebtoken');
const cert = require('./utils/jwt.config');

const app = express();
const server = http.createServer(app);
const io = socketio(server);

const PORT = 3000;

const whitelist = [
	"http://localhost:8081",
	"http://localhost:8080",
	"http://192.168.1.3:8080",
	"http://192.168.1.6",
	"http://192.168.1.7:8081",
	"http://192.168.1.9",
	"http://192.168.137.1",
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
app.use('/m/store', require('./routes/merchants/store'));
app.use('/m/order', require('./routes/merchants/orders'));

//* AUTH MIDDLEWARE
io.use((socket, next) => {
	if (socket.handshake.query && socket.handshake.query.token) {
		jwt.verify(socket.handshake.query.token, cert.public, (error, decoded) => {
			if (error) next(new Error('Auth error'));
			else next();
		});
	}
	else {
		next(new Error('No auth token provided'));
	}
})
// Register socket events in handler file
.on("connection", (socket) => registerOrderHandler(io, socket));

server.listen(PORT, () => {
	console.log(`Cofy Backend running on port ${ PORT }`);
});