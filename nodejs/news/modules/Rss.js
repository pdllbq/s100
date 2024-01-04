let Parser = require('rss-parser');

var Rss = 
{
    get: function(url, callback){
        let parser = new Parser();

        (async () => {

            let feed = await parser.parseURL(url);
            callback(feed);

        })();
    }
}

module.exports = Rss;