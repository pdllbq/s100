<?php
namespace App\Modules;

//use htmlpurifier
require_once base_path('vendor/ezyang/htmlpurifier/library/HTMLPurifier.auto.php');

use \App\Models\NewsSource;
use \App\Models\NewsPost;
use DOMDocument;

class RssReader
{
    public function getRandomFeed()
    {
        $sources = NewsSource::inRandomOrder()->first();

        return $sources;
    }

    public function parseRandomRss()
    {
        $feed = $this->getRandomFeed();

        try{
            $xml = simplexml_load_file($feed->url);
        } catch(\Exception $e) {
            dd('Cannot load RSS feed.'. $feed->url);
        }

        //Check If last or first item is already exists in the database- do nothing
        $lastItem = $xml->channel->item[(count($xml->channel->item) - 1)];
		$firstItem = $xml->channel->item[0];

        $lastPostCount = NewsPost::where('guid', $lastItem->guid)->count();
        $firstPostCount = NewsPost::where('guid', $firstItem->guid)->count();

        if($firstPostCount == 0){
            $items = array_reverse($xml->channel->xpath('item'));
        }else{
            $items = $xml->channel->item;
        }

        if($lastPostCount > 0 && $firstPostCount > 0){
            echo 'No new post found in RSS.';
            return true;
        }



        //If last or first item is not exists in the database- save it
        foreach($items as $data){
            echo $data->title.'<br>';

            //Save only if description has 255 characters or more with out html tags
            if(strlen(strip_tags($data->description)) >= 255){
            
                //Stop if the post is already exists in the database
                if(NewsPost::where('guid', $data->guid)->count() > 0){
                    echo 'Post already exists.<br><br>';
                    break;
                }

                $post = new NewsPost();
                $post->title = $data->title;
                $post->description = $data->description;
                $post->link = $data->link;
                $post->guid = $data->guid;
                $post->pub_date = $data->pubDate;
                $post->domain = $this->getDomain($feed->url);
                $post->img_url = $this->findImage($data);
                $post->language = $feed->lang;
                $post->save();
                echo 'Post saved.<br><br>';
            }else{
                echo 'Description is too short.<br>';
                echo 'Description: '.strip_tags($data->description).'<br><br>';
            }
        }

        return $xml;
    }

    function getDomain($url)
    {
        $parse = parse_url($url);
        return $parse['host'];
    }

    public function findImage($item)
    {
        if(isset($item->enclosure)){
            foreach($item->enclosure as $enclosure){
                if(isset($enclosure['url'])){
                    $ext = pathinfo($enclosure['url'], PATHINFO_EXTENSION);
                    if($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif' || $ext == 'webp'){
                        return $enclosure['url'];
                    }
                }
            }
        }

        if(isset($item->description) && !empty($item->description)){
            $dom = new DOMDocument();
            @$dom->loadHTML($item->description);
            $images = $dom->getElementsByTagName('img');
            foreach($images as $image){
                return $image->getAttribute('src');
            }
        }
    }
}