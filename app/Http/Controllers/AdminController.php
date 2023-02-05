<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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

        //Get sorces list
        // dd(getcwd());

        // $db = new JSONDB('../nodejs/news/db');
        // $sources = $db->select('*')
        //     ->from('sources.json')
        //     ->get();

        $json = file_get_contents('../nodejs/news/db/sources.json');

        dd($json);

        return exec('ls');


        return view('admin.news');
    }
}
