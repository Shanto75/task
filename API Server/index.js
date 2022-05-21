const connectMongo = require('./db');
var express = require('express');
connectMongo();
var app = express();
app.use(express.json())


//routes
app.use('/api/user', require('./routes/user'), require('./routes/about'))
// app.use('/api/about', require('./routes/about'))


app.get('/', function(req, res){
   res.send("Hello world!");
});

app.listen(5000);
