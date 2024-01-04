<?php

namespace App\Observers;

use App\Models\NewsFilterWords;

class NewsFilterWordsObserver
{
    function work(NewsFilterWords $newsFilterWords)
    {
        $words = $newsFilterWords->string;

        $words = str_replace("\r\n", "\n", $words);
        $words = str_replace("\r", "\n", $words);

        $wordsArr = explode("\n", $words);
        
        
    }
}
