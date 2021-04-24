const jwt = require('jsonwebtoken');
const config = require('../utils/jwt.config');

const verifyToken = (req, res, next) => {
    let token = req.headers['authorization'];
  
    if (!token){
        return res.status(403).send({ 
            auth: false, 
            message: 'No token provided.' 
        });
    }

    jwt.verify(token, config.secret, (err, decoded) => {
        if (err){
            return res.status(403).send({ 
                    auth: false, 
                    message: 'Fail to Authentication. Error -> ' + err 
                });
        }
        next();
    });
};

module.exports = verifyToken;