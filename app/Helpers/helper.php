<?php

//Replace relative path with absolute path
function replaceRelativePaths($text)
{
    $text = str_replace('/storage/post-files/','https://'.\request()->getHost().'/storage/post-files/',$text);
    $text = str_replace('/tag/','https://'.\request()->getHost().'/tag/',$text);

    return $text;
}