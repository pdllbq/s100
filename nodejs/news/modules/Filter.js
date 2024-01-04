var mysql = require('mysql');
var Mc = require('./Mc');

var Filter = {

    getTag: function(post, filterWords, callback){
        console.log('getTag for: '+post.title+'');

        let lang = post.lang;
        filterWords[lang].every(element => {
           //Finde words in post.ContentSnippet
           //console.log(post.contentSnippet);
            if(post.contentSnippet.indexOf(element.string) != -1){
                post.filter_id = element.filter_name_id;

                console.log('Filter: '+post.filter_id+'');
                callback(post);
                return false;
            }
        });

        console.log('Tag not found for: '+post.title+'');
    },

    getWords: function()
    {
        sql = "SELECT * FROM `news_filter_words`";

        var newWords = {};

        const words = Mc.syncQuery(sql);

        words.forEach(element => {
            if(!newWords[element.lang]){
                newWords[element.lang] = [];
            }

            newWords[element.lang].push(element);
        });
        
        return newWords;
    },

    getWordsOld: function(text)
    {
        console.log(cache.get('Filter.words'+this.lang));

        if(cache.get('Filter.words'+this.lang)){
            this.words = cache.get('Filter.words'+this.lang);

            this.getWordsCallback(this.words);

            console.log('cache')
        }else{
            var con = Mc.connect()

            var sql = "SELECT * FROM `news_filter_words` WHERE `lang` = '"+this.lang+"'";

            con.query(sql, function (err, result){
                if (err) throw err;

                Mc.end();

                cache.put('Filter.words'+this.lang, result, 60000);

                result.forEach(element => {
                    if(text.indexOf(element.string) != -1){
                        // console.log(text);
                        // console.log(element.filter_name_id);
                        // console.log('-----');
                        // console.log('-----');
                    }
                });
            });
        }
    }
}

module.exports = Filter;