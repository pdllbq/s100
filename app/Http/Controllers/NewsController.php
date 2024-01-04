<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

use App\Models\NewsPost;
use App\Models\NewsFilterName;

class NewsController extends Controller
{
    function index($locale){
        $title = __('news.index.title');
        $filters = self::getFilters($locale);

        $newsList = self::getNewsList();

        return view('news.index',compact(['title','filters','newsList']));
    }

    function filter($locale,$filterSlug)
    {
        $filters = self::getFilters($locale);

        $activeFilter = NewsFilterName
            ::where('lang',$locale)
            ->where('slug',$filterSlug)
            ->firstOrFail();

        $title = $activeFilter->name;

        $newsList = self::getNewsList($filterSlug);

        return view('news.index',compact(['title','filters','activeFilter','newsList']));
    }

    private function getNewsList($filterSlug = null)
    {
        $locale = app()->getLocale();

        $news = Cache::get('NewsController.getNewsList.'.$locale.'.'.$filterSlug, function() use ($filterSlug, $locale){
            if($filterSlug == null){
                $news = NewsPost::where('language',$locale)->orderBy('id','desc')->paginate(50);
            }else{
                $filter = NewsFilterName::where('language',$locale)->where('slug',$filterSlug)->firstOrFail();

                $news = NewsPost::where('filter_id', $filter->id)->orderBy('id','desc')->paginate(50);
            }

            Cache::put('NewsController.getNewsList.'.$locale.'.'.$filterSlug, $news, 3600); 

            return $news;
        });

        return $news;
    }

    private function getFilters($locale)
    {

        $filters = Cache::get('newsFilters_'.$locale, function() use ($locale){
            $filters = [];

            $allFilters = NewsFilterName::where('lang',$locale)->get();

            foreach($allFilters as $filter){
                $count = NewsPost::where('language',$locale)->where('filter_id',$filter->id)->count();
                if($count > 0){
                    $filters[] = $filter;
                }
            }

            Cache::put('newsFilters_'.$locale, $filters, 3600);

            return $filters;
        });

        return $filters;
    }
}
