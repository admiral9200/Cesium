const { check, validationResult } = require('express-validator');

const signupSanitizeRules = () => {
	return [
		check('email').not().isEmpty().withMessage('1').isEmail().withMessage('2').normalizeEmail().withMessage('3'),
		check('password').not().isEmpty().isLength({ min: 9}).trim().escape(),
		check('passwordConfirm').not().isEmpty().isLength({ min: 9}).trim().escape(),
		check('name').not().isEmpty().trim().escape(),
		check('surname').not().isEmpty().trim().escape(),
		check('mobile').not().isEmpty().trim().escape().isNumeric(),
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
		check('orderId').not().isEmpty().trim().escape()
	];
};

const AddressRules = () => {
	return [
		check('user').not().isEmpty().isEmail().withMessage('2').normalizeEmail(),
		check('address').not().isEmpty().trim().escape(),
		check('state').not().isEmpty().trim().escape()
	]
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
	validate
};