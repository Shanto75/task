const mongoose = require('mongoose');
const mongoURI = "mongodb://localhost:27017/user?readPreference=primary&appname=MongoDB%20Compass&ssl=false"
// const mongoURI = 'mongodb://localhost:27017/user'
const connectMongo = ()=>{
    mongoose.connect(mongoURI)
}

module.exports = connectMongo;