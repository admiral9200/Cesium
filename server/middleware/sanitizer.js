const { check, validationResult } = require('express-validator');

const signupSanitizeRules = () => {
	return [
		check('email').not().isEmpty().withMessage('Email is required').isEmail().withMessage('Email is not a valid format').normalizeEmail(),
		check('password').not().isEmpty().withMessage('Password is required').isLength({ min: 9}).trim().escape(),
		check('passwordConfirm').not().isEmpty().withMessage('Password is required').isLength({ min: 9}).trim().escape(),
		check('name').not().isEmpty().withMessage('Name is required').trim().escape(),
		check('surname').not().isEmpty().withMessage('Surname is required').trim().escape(),
		check('termsAccept').not().isEmpty().withMessage('Terms Acceptance is required').isBoolean()
	];
};

const loginSanitizeRules= () => {
	return [ 
		check('email').not().isEmpty().withMessage('Email is required').normalizeEmail().withMessage('3'), 
		check('password').not().isEmpty().withMessage('Password is required').trim().escape()
	];
};

const reorderSanitizeRules = () => {
	return [
		check('id').not().isEmpty().withMessage('ID is required').isNumeric().withMessage('Order id is invalid').trim().escape()
	];
};

const AddressRules = () => {
	return [
		check('address').not().isEmpty().trim().escape()
	];
};

const AddressRule = () => {
	return [
		check('address').not().isEmpty().trim().escape()
	];
};

const subscribeRule = () => {
	return [
		check('email').not().isEmpty().withMessage('1').isEmail().withMessage('2').normalizeEmail().withMessage('3'),
	];
};

const profileInfoRules = () => {
	return [
		check('name').not().isEmpty().isString().trim().escape(),
		check('surname').not().isEmpty().isString().trim().escape(),
		check('mobile').not().isEmpty().isNumeric().trim().escape(),
	];
};

const profileCredentialsRules = () => {
	return [
		check('oldpass').not().isEmpty().withMessage('Πρέπει να συμπληρώσεις τον τωρινό κωδικό').isString().trim().escape(),
		check('newpass').not().isEmpty().withMessage('Πρέπει να συμπληρώσεις τον καινούριο κωδικό').isString().trim().escape()
	];
};

const validate = (req, res, next) => {
	const errors = validationResult(req);
	if (errors.isEmpty()) {
		return next();
	}
	return res.send(errors);
};

module.exports = {
	loginSanitizeRules,
	signupSanitizeRules,
	reorderSanitizeRules,
	AddressRules,
	AddressRule,
	subscribeRule,
	profileInfoRules,
	profileCredentialsRules,
	validate
};