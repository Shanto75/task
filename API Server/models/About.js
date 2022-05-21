const mongoose = require('mongoose');
const { Schema } = mongoose;

const AboutSchema = new Schema({
    user:{
        type: mongoose.Schema.Types.ObjectId,
        ref: 'user'
    },
    about : {
       type: String,
       required: true
    },
});

const About = mongoose.model('about', AboutSchema);
module.exports = About;
