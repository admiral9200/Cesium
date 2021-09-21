const jwt = require('jsonwebtoken');
const cert = require('../utils/jwt.config');

const verifyToken = (req, res, next) => {
    if (!req.headers.authorization){
        return res.send({ 
            loggedIn: false, 
            message: 'You are logged off. Log in to continue' 
        });
    }

    jwt.verify(req.headers.authorization, cert.public, (error, decoded) => {
        if (error) {
            if (error.name === 'TokenExpiredError') {
                return res.send({ 
                    tokenExpired: true, 
                    message: 'Session expired. Log in again to continue.' 
                });
            }
            else {
                return res.send({
                    error: { 
                        tokenMalformed: true,
                        message: 'Session expired. Log in again to continue.' 
                    }
                });
            }
        }
        // TODO Maybe check user token to verify if it is not expired.. Use Redis for this
        next();
    });
};

module.exports = verifyToken;