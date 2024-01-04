var mysql = require('mysql');
const Mc = require('./Mc');

var con = mysql.createConnection({
    connectionLimit : 1,
    host: process.env.DB_HOST,
    user: process.env.DB_USERNAME,
    password: process.env.DB_PASSWORD,
    database: process.env.DB_DATABASE,
    port: process.env.DB_PORT,
    insecureAuth : true
});

var Sources = {

    // Get all sources
    get: function(callback) {
        var sql = "SELECT * FROM `news_sources`";

        const sources = Mc.syncQuery(sql);

        return sources;
    },

    // Test
    test: function() {
        console.log(process.env.DB_HOST);

        con.connect(function(err) {
            if (err) throw err;
            console.log("Connected!");
            con.end()
        });
    }
}

module.exports = Sources;