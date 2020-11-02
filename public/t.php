
<?php

// Ignore errors
libxml_use_internal_errors(true) AND libxml_clear_errors();

// http://stackoverflow.com/q/10237238/99923
// http://stackoverflow.com/q/12034235/99923
// http://stackoverflow.com/q/8218230/99923

// original input (unknown encoding)
$html = 'hi</b><p>سلام<div>の家庭に、9 ☆';

print $html . PHP_EOL;

$doc = new DOMDocument();
$doc->preserveWhiteSpace = false;
$doc->loadHTML($html);
print $doc->saveHTML($doc->documentElement) . PHP_EOL . PHP_EOL;

$doc = new DOMDocument('1.0', 'UTF-8');
$doc->loadHTML($html);
$doc->encoding = 'utf-8';
print $doc->saveHTML($doc->documentElement) . PHP_EOL . PHP_EOL;

$doc = new DOMDocument();
$doc->loadHTML('<?xml encoding="utf-8"?>' . $html);
$doc->encoding = 'utf-8';
print $doc->saveHTML($doc->documentElement) . PHP_EOL . PHP_EOL;

$doc = new DOMDocument('1.0', 'UTF-8');
$doc->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
print $doc->saveHTML($doc->documentElement) . PHP_EOL . PHP_EOL;


// Benchmark


print "Testing XML encoding spec" . PHP_EOL;
$time = microtime(TRUE);
for ($i=0; $i < 10000; $i++) { 
	$doc = new DOMDocument();
	$doc->loadHTML('<?xml encoding="utf-8"?>' . $html);

	foreach ($doc->childNodes as $item)
    	if ($item->nodeType == XML_PI_NODE)
        	$doc->removeChild($item); // remove hack
    

	$doc->encoding = 'utf-8';
	$doc->saveHTML();
	unset($doc);
}
print (microtime(TRUE) - $time) . " seconds" . PHP_EOL . PHP_EOL;

print "Testing mb_convert_encoding" . PHP_EOL;
$time = microtime(TRUE);
for ($i=0; $i < 10000; $i++) { 
	$doc = new DOMDocument();
	$doc->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
	$doc->saveHTML();
	unset($doc);
}
print (microtime(TRUE) - $time) . " seconds" . PHP_EOL . PHP_EOL;
