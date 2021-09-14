const bcrypt = require('bcrypt');

let input = process.argv[2];

bcrypt.hash(input, saltRounds = 10, async (error, encrypted) => {
	if (error) {
		console.log(error);
	}
	try {
		console.log(encrypted);
	} 
	catch (error) {
		console.log(error);
	}
});