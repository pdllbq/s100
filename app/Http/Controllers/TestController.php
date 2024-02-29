<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules\RssReader;
use App\Modules\NewsPurifier;

use function PHPSTORM_META\type;

class TestController extends Controller
{
    function index()
		{
			(new NewsPurifier());

			// $RssReader = new RssReader();

			// $xml = $RssReader->parseRandomRss();

			//$attributes = $xml->channel;

			// if(empty($attributes->description[0]))
			// {
			// 	dd('null');
			// }

			// foreach($attributes->item as $data)
			// {
			// 	echo $RssReader->findImage($data);
			// 	echo '<br><br>';
			// }

			//get the last item
			// $last = $xml->channel->item[(count($xml->channel->item) - 1)];
			// $first = $xml->channel->item[0];

			// echo $last->guid;
			// echo '<br><br>';

			// dd($attributes);

			// dd($attributes);

			// dd($xml->channel->item[1]);


		}
}
