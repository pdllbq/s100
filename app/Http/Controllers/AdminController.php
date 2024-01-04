<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use \App\Models\NewsSource;
use \App\Models\NewsFilterName;
use App\Models\NewsFilterWords;

class AdminController extends Controller
{
    //isAdmin
    public function onlyAdmin()
    {
        $isAdmin = Auth::user()->is_admin;
        if ($isAdmin == 0) {
            return abort(404);
        }
    }

    //Main page
    function index($locale)
    {
        $this->onlyAdmin();

        return view('admin.index');
    }

    //News
    function news($locale)
    {
        $this->onlyAdmin();

        $sources = NewsSource::select('*')->get();

        return view('admin.news', compact('sources'));
    }

    //News store
    function newsStore(Request $request, $locale)
    {
        $this->onlyAdmin();

        $request->validate([
            'add_source_url' => 'required',
            'add_source_lang' => 'required'
        ]);

        //Check if source already exists
        $source = NewsSource::where('url', $request->add_source_url)->count();
        if ($source > 0) {
            return redirect(route('admin.news', app()->getLocale()))->withErrors(__('admin.Source already exists'));
        }

        //Save
        $source = new NewsSource();
        $source->url = $request->add_source_url;
        $source->lang = $request->add_source_lang;                  
        $source->save();
        //

        return redirect(route('admin.news', app()->getLocale()))->with('status', __('admin.Source added'));
    }

    //News update
    function newsUpdate(Request $request, $locale)
    {
        $this->onlyAdmin();

        //Check errors
        if ($request->edit_source_url == '') {
            $error = ['error' => __('admin.Source url is required')];
            $error = json_encode($error);

            return $error;
        }
        if ($request->edit_source_lang == '') {
            $error = ['error' => __('admin.Source language is required')];
            $error = json_encode($error);

            return $error;
        }
        if ($request->edit_source_id == '') {
            $error = ['error' => __('admin.Source id is required')];
            $error = json_encode($error);

            return $error;
        }

        //Update
        $source = NewsSource::find($request->edit_source_id);
        $source->url = $request->edit_source_url;
        $source->lang = $request->edit_source_lang;
        $source->save();

        $request->session()->flash('status', __('admin.Source updated'));

        $error = ['success' => __('admin.Source updated')];
        $error = json_encode($error);

        return $error;
    }

    //News delete
    function newsDelete($locale, $id)
    {
        $this->onlyAdmin();

        $source = NewsSource::find($id);
        $source->delete();

        return redirect(route('admin.news', app()->getLocale()))->with('status', __('admin.Source deleted'));
    }

    //News filters
    function newsFilters($locale)
    {
        $this->onlyAdmin();

        $filters = NewsFilterName::select('*')->get();

        // dd($filters[0]->words);

        return view('admin.newsFilters', compact('filters'));
    }

    //News filters store
    function newsFiltersStore(Request $request, $locale)
    {
        $this->onlyAdmin();

        $request->validate([
            'filter' => 'required',
            'lang' => 'required',
        ]);

        //Save
        $filter = new NewsFilterName();
        $filter->name = $request->filter;
        $filter->lang = $request->lang;
        $filter->slug = \Str::slug($request->filter);
        $filter->save();
        //

        return redirect(route('admin.news.filters', app()->getLocale()))->with('status', __('admin.Filter added'));
    }

    //News filters update
    function newsFiltersUpdate(Request $request, $locale)
    {
        $this->onlyAdmin();

        //Check errors
        if ($request->edit_filter_name == '') {
            $error = ['error' => __('admin.Filter name is required')];
            $error = json_encode($error);

            return $error;
        }
        if ($request->edit_filter_lang == '') {
            $error = ['error' => __('admin.Filter language is required')];
            $error = json_encode($error);

            return $error;
        }
        if ($request->edit_filter_id == '') {
            $error = ['error' => __('admin.Filter id is required')];
            $error = json_encode($error);

            return $error;
        }

        //Update
        $filter = NewsFilterName::find($request->edit_filter_id);
        $filter->name = $request->edit_filter_name;
        $filter->lang = $request->edit_filter_lang;
        $filter->slug = \Str::slug($request->edit_filter_name);
        $filter->save();

        $request->session()->flash('status', __('admin.Filter updated'));

        $error = ['success' => __('admin.Filter updated')];
        $error = json_encode($error);

        return $error;
    }

    //News filters delete
    function newsFiltersDelete($locale, $id)
    {
        $this->onlyAdmin();

        $filter = NewsFilterName::find($id);
        $filter->delete();

        NewsFilterWords::where('filter_name_id', $id)->delete();

        return redirect(route('admin.news.filters', app()->getLocale()))->with('status', __('admin.Filter deleted'));
    }

    //News filters words add
    function newsFiltersWordsStore(Request $request, $locale)
    {
        $this->onlyAdmin();

        $request->validate([
            'words' => 'required',
            'filter_id' => 'required',
        ]);

        //Get filter by id
        $filter = NewsFilterName::find($request->filter_id);
        $lang = $filter['lang'];

        $words = $request->words;

        $words = str_replace("\r\n", "\n", $words);
        $words = str_replace("\r", "\n", $words);
        $wordsArr = explode("\n", $words);

        $wordsArr = array_unique($wordsArr);

        NewsFilterWords::where('filter_name_id', $request->filter_id)->delete();

        foreach ($wordsArr as $word) {
            $word = trim($word);

            if ($word != '') {
                $NewsFilterWords = new NewsFilterWords();
                $NewsFilterWords->filter_name_id = $request->filter_id;
                $NewsFilterWords->string = $word;
                $NewsFilterWords->lang = $lang;
                $NewsFilterWords->save();
            }
        }

        return redirect(route('admin.news.filters', app()->getLocale()))->with('status', __('admin.Filter updated'));
    }

}