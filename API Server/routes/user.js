const express = require("express");
const User = require("../models/User");
var bcrypt = require("bcryptjs");
const router = express.Router();
const { body, validationResult } = require("express-validator");
var jwt = require("jsonwebtoken");
var fetchuser = require('../middleware/fetchuser');
const jwt_secret = "mynameisshanto";



//ROUTE 1
// create a new user , POST "/api/user/signup"
router.post(
  "/signup",
  [
    body("name", "Enter a valid name").isLength({ min: 3 }),
    body("email", "Enter a valid email").isEmail(),
    body("pass", "Enter a valid password").isLength({ min: 3 }),
  ],
  async (req, res) => {
    const errors = validationResult(req);
    if (!errors.isEmpty()) {
      return res.status(400).json({ errors: errors.array() });
    }

    try {
      let findUser = await User.findOne({ email: req.body.email });
      if (findUser) {
        return res.status(400).json({ error: "Invalid Entry!" });
      }
      const salt = await bcrypt.genSalt(10);
      const hashPass = await bcrypt.hash(req.body.pass, salt);

      let user = await User.create({
        name: req.body.name,
        email: req.body.email,
        pass: hashPass,
      });

      const data = {
        user: {
          id: user.id,
        },
      };

      const usertoken = jwt.sign(data, jwt_secret);

      res.json({ usertoken });
    } catch (error) {
      console.error(error.message);
      res.status(500).send("Internal Server Error");
    }
  }
);

//ROUTE 2
//user login validation, POST "/api/user/login"
router.post(
  "/login",
  [
    body("email", "Enter a valid email").isEmail(),
    body("pass", "Enter a valid password").exists(),
  ],
  async (req, res) => {
    const errors = validationResult(req);
    if (!errors.isEmpty()) {
      return res.status(400).json({ errors: errors.array() });
    }

    const { email, pass } = req.body;
    try {
      //email exist or not in the database
      let findUser = await User.findOne({ email });
      if (!findUser) {
        return res
          .status(400)
          .json({ error: "Invalid Entry! Enter valid Email or password" });
      }

      // if email exit validate the password
      const comparePassword = await bcrypt.compare(pass, findUser.pass);
      if (!comparePassword) {
        return res
          .status(400)
          .json({ error: "Invalid Entry! Enter valid Email or password" });
      }

      const data = {
        user: {
          id: findUser.id,
        },
      };

      const usertoken = jwt.sign(data, jwt_secret);

      res.json({ usertoken });
    } catch (error) {
      console.error(error.message);
      res.status(500).send("Internal Server Error");
    }
  }
);

//ROUTE 3
//get logged in user details using, POST "/api/user/getuser".   here login is required
router.post("/getuser", fetchuser, async (req, res) => {

  try {
    const userid = req.user.id;
    const user = await User.findById(userid).select("-pass");
    res.send(user);
    
  } catch (error) {
    console.error(error.message);
    res.status(500).send("Internal Server Error");
  }
});

module.exports = router;
