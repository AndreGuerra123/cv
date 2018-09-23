let express = require('express');
let server = express();
server.use('/', express.static(__dirname));
server.on('connection',()=>{console.log("C.V. on port 8080.")})
server.listen(8080);


