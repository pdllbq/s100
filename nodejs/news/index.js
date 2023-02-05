require('dotenv').config({path:'../../.env'})

const Sources = require('./modules/Sources')

// Get mode (test)
const param = process.argv[2];

// Get sources
let sourcesList=Sources.get();

// If test mode
if(param == 'test'){
    // Log sources
    console.log(sourcesList);
}