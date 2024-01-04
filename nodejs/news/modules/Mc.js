var mysql = require('mysql');
var syncSql = require('sync-sql');

var con = mysql.createPool({
    connectionLimit : 1,
    host: process.env.DB_HOST,
    user: process.env.DB_USERNAME,
    password: process.env.DB_PASSWORD,
    database: process.env.DB_DATABASE,
    port: process.env.DB_PORT,
    insecureAuth : true
});

var timeout;

var Mc = {
    connect: function(){
        return con;
    },

    end: function()
    {
        if(timeout){
            clearTimeout(timeout);
            //console.log('clearTimeout');
        }

        timeout = setTimeout(function(){
            con.end();
        }, 60000);

    },

    syncQuery: function(sql){
        var output = syncSql.mysql(
            {
                host: process.env.DB_HOST,
                user: process.env.DB_USERNAME,
                password: process.env.DB_PASSWORD,
                database: process.env.DB_DATABASE,
                port: process.env.DB_PORT,
            },
            sql
        );

        //console.log(output);

        if(output.success != true){
            throw output.data.err;
        }

        return output.data.rows;
    }
}

module.exports = Mc;