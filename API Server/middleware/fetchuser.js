var jwt = require("jsonwebtoken");
const jwt_secret = "mynameisshanto";

const fetchuser = (req, res, next) => {
  const token = req.header("user-token");

  if (!token) {
    res.status(401).send({ error: "Invalid token! use a valid token" });
  }

  try {
    const data = jwt.verify(token, jwt_secret);
    req.user = data.user;
  
    next();
  } catch (error) {
    res.status(401).send({ error: "Invalid token! use a valid token" });
  }
};

module.exports = fetchuser;
