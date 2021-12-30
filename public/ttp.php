<?php

$str='<p><script>embedTiktok(\'https://www.tiktok.com/@kikakiim/video/7028579657507294465?sender_device=pc&sender_web_id=6890825948154283526&is_from_webapp=v1&is_copy_url=0\',\'7028579657507294465\',7415946);</script> <span id="embedTiktok_7028579657507294465_7415946"></span></p><div class="tiktokStart"></div><blockquote class="tiktok-embed" cite="https://www.tiktok.com/@kikakiim/video/7028579657507294465?sender_device=pc&amp;sender_web_id=6890825948154283526&amp;is_from_webapp=v1&amp;is_copy_url=0" data-video-id="7028579657507294465" style="max-width: 605px;min-width: 325px;" id="v9905160616717424">  <iframe style="width: 100%; height: 597px; display: block; visibility: unset; max-height: 597px;" name="__tt_embed__v9905160616717424" src="https://www.tiktok.com/embed/v2/7028579657507294465?lang=ru-RU"></iframe></blockquote> <script async="" src="https://www.tiktok.com/embed.js"></script><div class="tiktokEnd"></div><br><script>embedTiktok(\'https://www.tiktok.com/@mairisbriedis13/video/7032297416900545797?sender_device=pc&sender_web_id=6890825948154283526&is_from_webapp=v1&is_copy_url=0\',\'7032297416900545797\',2213627);</script> <span id="embedTiktok_7032297416900545797_2213627"><div class="tiktokStart"></div><blockquote class="tiktok-embed" cite="https://www.tiktok.com/@mairisbriedis13/video/7032297416900545797?sender_device=pc&amp;sender_web_id=6890825948154283526&amp;is_from_webapp=v1&amp;is_copy_url=0" data-video-id="7032297416900545797" style="max-width: 605px;min-width: 325px;" id="v69905945417443330">  <iframe style="width: 100%; height: 578px; display: block; visibility: unset; max-height: 578px;" name="__tt_embed__v69905945417443330" src="https://www.tiktok.com/embed/v2/7032297416900545797?lang=ru-RU"></iframe></blockquote> <script async="" src="https://www.tiktok.com/embed.js"></script><div class="tiktokEnd"></div></span><p></p>';

//Удаление кола тиктока
$patern='~<div class="tiktokStart"></div>(.*?)<div class="tiktokEnd"></div>~';
$cut=preg_match_all($patern,$str,$cutArr);

foreach($cutArr[1] as $cutPatern){
    $str=str_replace($cutPatern,'',$str);
}

$str=str_replace('<div class="tiktokStart"></div><div class="tiktokEnd"></div>','',$str);
//

//Создание BB-кода
//$patern='<script>embedTiktok(\'https://www.tiktok.com/@kikakiim/video/7028579657507294465?sender_device=pc&sender_web_id=6890825948154283526&is_from_webapp=v1&is_copy_url=0\',\'7028579657507294465\',7415946);</script>';
$patern='~<script>embedTiktok\(\'(.*?)\',\'(.*?)\',(.*?)\);</script>~';
preg_match_all($patern,$str,$replaceArr);

$count=count($replaceArr);

for($i=0; $i<$count; $i++){
    $str=str_replace($replaceArr[0][$i],'[tiktok]'.$replaceArr[1][$i].'|'.$replaceArr[2][$i].'|'.$replaceArr[3][$i].'[/tiktok]',$str);
}
//

//Удалить span для встраивания тикток
$patern='~<span id="embedTiktok_(.*?)_(.*?)"></span>~';
$str=preg_replace($patern,'',$str);

print_r($str);

?>


<br><br><br>
####################################################################
<br><br><br>


<?php

$patern='~\[tiktok\](.*?)\|(.*?)\|(.*?)\[/tiktok\]~';

preg_match_all($patern,$str,$replaceArr2);

$count=count($replaceArr2);

for($i=0; $i<$count; $i++)
{
    $str= str_replace($replaceArr2[0][$i], '<script>embedTiktok('.$replaceArr2[1][$i].','.$replaceArr2[2][$i].','.$replaceArr2[3][$i].');</script> <span id="embedTiktok_'.$replaceArr2[2][$i].'_'.$replaceArr2[3][$i].'"></span>', $str);
}

print_r($str);