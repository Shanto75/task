const express = require("express");
const router = express.Router();
var fetchuser = require("../middleware/fetchuser");
const { body, validationResult } = require("express-validator");
const About = require("../models/About");

//ROUTE 1
//get logged in user About using, GET "/api/user/getabout". here login is required
router.get("/getabout", fetchuser, async (req, res) => {
  try {
    const userAbout = await About.find({ user: req.user.id });
    res.json(userAbout);
  } catch (error) {
    console.error(error.message);
    res.status(500).send("Internal Server Error");
  }
});

//ROUTE 2
//add user About using, POST "/api/user/addabout". here login is required
router.post(
  "/addabout",
  fetchuser,
  [body("about", "Enter valid information").isLength({ min: 5 })],
  async (req, res) => {
    try {
      const { about } = req.body;

      const errors = validationResult(req);
      if (!errors.isEmpty()) {
        return res.status(400).json({ errors: errors.array() });
      }

      const userAbout = new About({
        user: req.user.id,
        about,
      });

      const saveAbout = await userAbout.save();
      res.json(saveAbout);
    } catch (error) {
      console.error(error.message);
      res.status(500).send("Internal Server Error");
    }
  }
);

//ROUTE 3
//update user About using, PUT "/api/user/updateabout". here login is required
router.put("/updateabout/:id", fetchuser, async (req, res) => {
  const { about } = req.body;
  try {
    //create a new about object
    const newAbout = {};
    if (about) {
      newAbout.about = about;
    }

    //find the user by id
    let findAbout = await About.findById(req.params.id);
    if (!findAbout) {
      return res.status(400).send("Not Found");
    }

    if (findAbout.user.toString() !== req.user.id) {
      return res.status(401).send("You are not allowed to update");
    }

    const updateAbout = await About.findByIdAndUpdate(
      req.params.id,
      { $set: newAbout },
      { new: true }
    );
    res.json({ updateAbout });
  } catch (error) {
    console.error(error.message);
    res.status(500).send("Internal Server Error");
  }
});

//ROUTE 4
//Delete user About using, DELETE "/api/user/deleteabout". here login is required
router.delete("/deleteabout/:id", fetchuser, async (req, res) => {
  try {
    //find the user by id
    let findAbout = await About.findById(req.params.id);
    if (!findAbout) {
      return res.status(400).send("Not Found");
    }

    if (findAbout.user.toString() !== req.user.id) {
      return res.status(401).send("You are not allowed to delete");
    }

    const deleteAbout = await About.findByIdAndDelete(req.params.id);
    res.json({ "Success": "About has been deleted" });

  } catch (error) {
    console.error(error.message);
    res.status(500).send("Internal Server Error");
  }
});

module.exports = router;
