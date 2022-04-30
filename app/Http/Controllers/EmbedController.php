<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmbedController extends Controller
{
    function tiktok($userName,$videoId)
		{
			return view('embed.tiktok',compact(['userName','videoId']));
		}

		function youtube($videoId)
		{
			return view('embed.youtube',compact(['videoId']));
		}

		function telegram($groupName,$postId)
		{
			return view('embed.telegram',compact(['groupName','postId']));
		}
}
