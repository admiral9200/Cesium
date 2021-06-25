const fs = require('fs');

const public_key = fs.readFileSync('C:\\Users\\z3r0Luck\\Documents\\Personal_Projects\\Project_Cesium\\server\\utils\\public.key', 'utf-8');
const private_key  = fs.readFileSync('C:\\Users\\z3r0Luck\\Documents\\Personal_Projects\\Project_Cesium\\server\\utils\\private.key', 'utf8');

module.exports = {
	'secret': private_key,
	'public': public_key
};