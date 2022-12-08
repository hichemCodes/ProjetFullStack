const express = require('express');
var cors = require('cors')
const app = express();
 app.use(cors())
app.use(express.json());
 
app.get('/', (req, res) => {
  res.send("hello World");
});
 
app.post('/', (req, res) => {
    console.log(req.body)
  const {name, age } = req.body;
  const { authorization } = req.headers;
  res.send({
name,
age,
  });
});
 
app.listen(80, () => {
 console.log('Our express server is up on port 80');
});