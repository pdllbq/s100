const sourcesListPath = 'db/sources.json';
const Datastore = require('nedb');

let Sources = {
    get: function(){
        let db = new Datastore({ filename: sourcesListPath, autoload: true });

        db.insert({ url: 'https://s100.lv/ru/rss', lang: 'en' });
        db.insert({ url: 'https://s100.lv/lv/rss', lang: 'fr' });
    }
}

module.exports = Sources;