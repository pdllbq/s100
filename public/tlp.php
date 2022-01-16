<?php

$str='<script async="" src="https://telegram.org/js/telegram-widget.js" data-telegram-post="s100lv/2" data-width="100%"></script>';
$str.='<script async="" src="https://telegram.org/js/telegram-widget.js" data-telegram-post="s100lv/3" data-width="100%"></script>';
$str='fdsf';


$patern='~<script async="" src="https://telegram.org/js/telegram-widget.js" data-telegram-post="(.*?)" data-width="100%"></script>~';

preg_match_all($patern,$str,$replaceArr);

$count=count($replaceArr);

for($i=0; $i<$count; $i++){
    $str=str_replace($replaceArr[0][$i],'[telegram]'.$replaceArr[1][$i].'[/telegram]',$str);
}

print_r($str);
?>

<br><br><br>~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~<br><br><br>

<?php
$patern='~\[telegram\](.*?)\[/telegram\]~';

preg_match_all($patern,$str,$replaceArr);



$count=count($replaceArr);

for($i=0; $i<$count; $i++){
    $str=str_replace($replaceArr[0][$i],'<script async="" src="https://telegram.org/js/telegram-widget.js" data-telegram-post="'.$replaceArr[1][$i].'" data-width="100%"></script>',$str);
}

print_r($str);