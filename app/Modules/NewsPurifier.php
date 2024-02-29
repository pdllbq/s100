<?php
namespace App\Modules;

use Illuminate\Support\Str;

use App\Models\NewsPost;

require_once base_path('vendor/ezyang/htmlpurifier/library/HTMLPurifier.auto.php');

class NewsPurifier
{
    var $news;

    function __construct()
    {
        $newsPost = new NewsPost();

        $news = $newsPost->where('purified', 0)->get();

        $this->news = $news;

        $this->purify();
    }

    function purify()
    {
        foreach($this->news as $data)
        {
            //Restore html tags after htmlspecialcharacters
            $dirtyDescription = htmlspecialchars_decode($data->description);

            //Delete all tags from title
            $title = strip_tags($data->title);

            //Delete all html tags except p and br from description
            $config = \HTMLPurifier_Config::createDefault();
            $config->set('HTML.Allowed', 'p,br');
            $purifier = new \HTMLPurifier($config);
            $description = $purifier->purify($dirtyDescription);

            //Save the purified data
            $newsPost = NewsPost::find($data->id);
            $newsPost->purified_title = $title;
            $newsPost->purified_description = $description;
            $newsPost->purified_excerpt = Str::limit($description, 127);
            //$newsPost->purified = 1;
            $newsPost->save();
        }
    }
}