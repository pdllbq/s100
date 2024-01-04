require('dotenv').config({path:'../../.env'})

let Sources = require('./modules/Sources');
let Rss = require('./modules/Rss');
const Filter = require('./modules/Filter');
let Parser = require('rss-parser');
let HtmlParser = require('node-html-parser');
let path = require('path');
let Mc = require('./modules/Mc');
const stringSimilarity = require('string-similarity');

class Post {
    constructor(){
        this.title;
        this.link;
        this.pubDate;
        this.content;
        this.contentSnippet;
        this.guid;
        this.imgUrl;
        this.domain;
        this.filterId;
        this.language;
    }
}

class Data {
    constructor()
    {
        this.sources;
        this.lastPosts;
        this.filterWords;
    }
}

var save;
var checkGuidCount = 0;

var data = new Data();

// Get mode (test)
const param = process.argv[2];

//Get img url from item
function getImgUrl(item)
{
    if(item.enclosure){
        if(item.enclosure.url){
            var ext = path.extname(item.enclosure.url);

            if(ext == '.jpg' || ext == '.png' || ext == '.gif' || ext == '.jpeg' || ext == '.webp'){
                return item.enclosure.url;
            }
        }
    }

    var img = HtmlParser.parse(item.content).querySelector('img');
    if(img){
        var imgUrl = img.getAttribute('src');

        return imgUrl;
    }

    return null;
}

function domainFromUrl(url)
{
    const urlObj = new URL(url);
    const domain = urlObj.hostname;

    return domain;
}

//Similirity
function similarity(post)
{
    console.log('similarity for: '+post.title+'');

    // console.log(post);
    // return;

    post.similarity_percentage = 0;
    post.similarity_parent = 0;

    if(data.lastPosts[post.lang]){

        data.lastPosts[post.lang].forEach((element, key, arr) => {

            let s = stringSimilarity.compareTwoStrings(element.content_snippet, post.contentSnippet);

            if(!post.similarity_percentage || post.similarity_percentage < s){
                post.similarity_percentage = s;
                post.similarity_parent = element.id;
            }

            console.log(arr.length);
        });

    }
    
    savePost(post);
}

//Check guid
function checkGuid(post)
{
    console.log('checkGuid for: '+post.guid+'');

    checkGuidCount++;

    let con = Mc.connect();

    //console.log(similarity);

    var sql = "SELECT * FROM `news_posts` WHERE `guid` = '"+post.guid+"'";
    con.query(sql, function (err, result){
        if (err) throw err;

        Mc.end();

        //console.log(similarity);

        if(result.length == 0){
            //console.log(similarity)
            similarity(post);
        }
    });
}

//Save post to db
function savePost(post)
{
    console.log('savePost: '+post.title+'');

    if(save && save == post.guid){
        console.log('Tag id: '+post.filter_id+'');
        return;
    }

    save = post.guid;

    let con = Mc.connect()

    let sql = "INSERT INTO `news_posts` (`creator`, `title`, `link`, `pub_date`, `content`, `content_snippet`, `guid`, `img_url`, `domain`, `filter_id`, `language`, `similarity_percentage`, `similarity_parent`) VALUES ?";

    let values = [
        [
            post.creator,
            post.title,
            post.link,
            post.pubDate,
            post.content,
            post.contentSnippet,
            post.guid,
            post.img,
            post.domain,
            post.filter_id,
            post.lang,
            post.similarity_percentage,
            post.similarity_parent
        ]
    ]

    con.query(sql, [values], function (err, result){
        if (err) throw err;

        Mc.end();

        console.log('Post saved: '+post.title+'');

        console.log('checkGuidCount: '+checkGuidCount+'');
    });
}

//Parse rss feeds
function parseRss(sources)
{
    console.log('Parsing rss feeds...')

    sources.forEach(element => {
        Rss.get(element.url, function(feed){
            var lang = element.lang;
            feed.items.forEach(element => {
                let post = element;
                post.lang = lang;
    
                post.domain = domainFromUrl(element.link);
                //console.log(post.domain);

                var img = getImgUrl(element);
                if(img){
                    post.img = img;
                }else{
                    post.img = null;
                }

                // console.log(post);
                // return;

                Filter.getTag(post, data.filterWords, checkGuid);
            });
        });
    });
}

//Get last posts
function getLastPosts()
{
    var sql = "SELECT * FROM `news_posts` WHERE `created_at` > CURDATE() - INTERVAL 1 DAY";

    const posts = Mc.syncQuery(sql);

    let newPosts = {};

    posts.forEach(element => {
        if(!newPosts[element.language]){
            newPosts[element.language] = [];
        }

        newPosts[element.language].push(element);
    });

    data.lastPosts = newPosts;

    return newPosts;
}

console.log('Start');

data = new Data();
data.sources = Sources.get();
data.lastPosts = getLastPosts();
data.filterWords = Filter.getWords();

parseRss(data.sources);

console.log('Finished');

// If test mode
// if(param == 'test'){
//     //Sources.get(sources);
//}