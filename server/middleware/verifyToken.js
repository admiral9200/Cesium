const jwt = require('jsonwebtoken');
const cert = require('../utils/jwt.config');

const verifyToken = (req, res, next) => {
    let token = req.headers['authorization'];
  
    if (!token){
        return res.status(403).send({ 
            auth: false, 
            message: 'You are logged off' 
        });
    }

    jwt.verify(token, cert.public, (error, decoded) => {
        if (error) {
            console.log(error);
            return res.status(403).send({ 
                    auth: false, 
                    message: 'Fail to authenticate. Try logging in again' 
                });
        }
        // TODO Maybe check user to verify if it is not expired.. Use Redis for this
        next();
    });
};

module.exports = verifyToken;