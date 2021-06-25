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
            console.log(decoded);
            return res.status(403).send({ 
                    auth: false, 
                    message: 'Fail to authenticate. Try again' 
                });
        }
        next();
    });
};

module.exports = verifyToken;