var mysql = require('mysql');

var con = mysql.createConnection({
    host: process.env.DB_HOST,
    user: process.env.DB_USERNAME,
    password: process.env.DB_PASSWORD,
    database: process.env.DB_DATABASE,
    port: process.env.DB_PORT,
    insecureAuth : true
});

var Posts = {
    
    //Insert post
    insert: function(post)
    {
        sql = "INSERT INTO `news_posts` (`creator`,`title`,`linl`,`pub_date`,`content`,`content_snippet`,`guid`,`img_url`,`domain`,`filter_id`,`language`) VALUES ?";
    }
}

module.exports = Posts;