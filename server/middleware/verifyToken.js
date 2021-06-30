const jwt = require('jsonwebtoken');
const cert = require('../utils/jwt.config');

const verifyToken = (req, res, next) => {
    if (!req.headers.authorization){
        return res.status(403).send({ 
            auth: false, 
            message: 'You are logged off' 
        });
    }

    jwt.verify(req.headers.authorization, cert.public, (error, decoded) => {
        if (error) {
            console.log(error);
            return res.status(403).send({ 
                    auth: false, 
                    message: 'Fail to authenticate. Try logging in again' 
                });
        }
        // TODO Maybe check user token to verify if it is not expired.. Use Redis for this
        next();
    });
};

module.exports = verifyToken;