const express = require('express');
const cors = require('cors');

const app = express();

const port = 3000;

var corsOptions = {
	origin: ["http://localhost:8081", "http://192.168.1.3:8081"]
};

app.use(cors(corsOptions));

app.use(express.json());
app.use(express.urlencoded({ extended: false }));

app.use('/auth' , require('./routes/auth'));

app.use('/order' , require('./routes/order'));

app.use('/home' , require('./routes/home'));

app.listen(port, () => {
	console.log(`Chip Coffee Backend running on port ${ port }`);
});