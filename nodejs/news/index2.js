require('dotenv').config({path:'../../.env'});

const async = require('async');
const mysql = require('mysql');

const conn = mysql.createConnection({
    host: process.env.DB_HOST,
    user: process.env.DB_USERNAME,
    password: process.env.DB_PASSWORD,
    database: process.env.DB_DATABASE,
    port: process.env.DB_PORT,
});

async function getFeedsList()
{

}

async function dbConnect()
{
    await conn.connect(err => {
        if(err){
            console.log('Error connecting to Db');
            return false;
        }
        console.log('Connection established');
    })
}

async function run()
{
    let connStatus = await dbConnect();
    if(connStatus == false){
        return false;
    }
}

run()

conn.end();