const { check, validationResult } = require('express-validator');

const signupSanitizeRules = () => {
	return [
		check('email').not().isEmpty().withMessage('1').isEmail().withMessage('2').normalizeEmail().withMessage('3'),
		check('password').not().isEmpty().isLength({ min: 9}).trim().escape(),
		check('passwordConfirm').not().isEmpty().isLength({ min: 9}).trim().escape(),
		check('name').not().isEmpty().trim().escape(),
		check('surname').not().isEmpty().trim().escape(),
		check('termsAccept').not().isEmpty().isBoolean()
	];
};

const loginSanitizeRules= () => {
	return [ 
		check('email').not().isEmpty().withMessage('1').isEmail().withMessage('2').normalizeEmail().withMessage('3'), 
		check('password').not().isEmpty().trim().escape()
	];
};

const reorderSanitizeRules = () => {
	return [
		check('id').not().isEmpty().withMessage('ID is empty').isNumeric().withMessage('Order id is invalid').trim().escape()
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