<?php
namespace App\Modules;

//html purifier
require_once base_path('vendor/ezyang/htmlpurifier/library/HTMLPurifier.auto.php');

class HtmlPurifier
{
    //tag[attributes]
    protected $allowedTags = 'p[],br[]';

    function __construct($allowedTags = null)
    {
        $this->allowedTags = $allowedTags;
    }
    
    public function purify($html)
    {
        $config = \HTMLPurifier_Config::createDefault();
        $config->set('HTML.Allowed', $this->allowedTags);
        $purifier = new \HTMLPurifier($config);
        return $purifier->purify($html);
    }
}