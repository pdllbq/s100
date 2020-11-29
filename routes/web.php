<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/home', function () {
    $locale = session('locale','ru');
	if($locale!='en' && $locale!='ru' && $locale!='lv'){
		$locale='ru';
	}
    //print_r($locale); exit;
    return redirect('/'.$locale);
});

Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
	Route::get('login/facebook', 'Auth\LoginController@redirectToFacebook');
});
Route::get('login/facebook/callback', 'Auth\LoginController@handleFacebookCallback');

Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
  Route::resource('message','MessageController')->except('create');
});

Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
	Route::get('/message/create/{userName}','MessageController@create')->name('message.create');
});

Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
	Route::get('/message/delete/{id}','MessageController@delete')->name('message.delete');
});

Route::group(['prefix' => '{locale}','middleware'=>'setlocale'], function(){
    Route::get('/','PostController@index')->name('home');
});
Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
  Route::resource('post','PostController')->except('show');
});
Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
  Route::get('new','PostController@new')->name('post.new');
});
Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
  Route::get('draft','PostController@draft')->name('post.draft');
});
Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
  Route::get('subscribes','PostController@subscribes')->name('post.subscribes');
});

Route::group(['prefix' => '{locale}','middleware'=>'setlocale'], function(){
    Auth::routes();
});

Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
  Route::get('@{userName}','UserController@show')->name('user.show');
});


Route::get('/tag/{tag}','PostController@preTag')->name('post.preTag');
Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
  Route::get('/tag/{tag}','PostController@tag')->name('post.tag');
});

Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
  Route::get('{slug}','PostController@show')->name('post.show');
});

Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
  Route::get('/subscribes','PostController@subscribes')->name('post.subscribes');
});

Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
  Route::post('/post/add-comment','PostController@addComment')->name('post.addComment');
});

Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
  Route::get('/post/get-answers/{commentId}','PostController@commentGetAnswers')->name('post.getAnswers');
});

Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
  Route::get('/post/destroy/{slug}','PostController@destroy')->name('post.destroy');
});

Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
  Route::get('/post/plus/{slug}','PostController@plus')->name('post.plus');
});

Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
  Route::get('/post/minus/{slug}','PostController@minus')->name('post.minus');
});

Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
  Route::get('@{userName}','UserController@show')->name('user.show');
});

Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
  Route::get('/subscribe/user/{userId}','SubscribeController@user')->name('subscribe.user');
});

Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
  Route::get('/subscribe/tag/{tag}','SubscribeController@tag')->name('subscribe.tag');
});

Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
  Route::get('/subscribe/g/{slug}','SubscribeController@group')->name('subscribe.group');
});

Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
  Route::get('/user/profile','UserController@profile')->name('user.profile');
});

Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
  Route::post('/user/profile/save','UserController@profileSave')->name('user.profileSave');
});

Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
  Route::post('/user/profile/upload-avatar','UserController@uploadAvatar')->name('user.uploadAvatar');
});

Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
	Route::post('/g/make','GroupController@make')->name('group.make');
});

Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
	Route::get('/g/{slug}','GroupController@show')->name('group.show');
});

Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
	Route::get('/g/destroy/{slug}','GroupController@destroy')->name('group.destroy');
});

Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
	Route::get('/g/edit/{slug}','GroupController@edit')->name('group.edit');
});

Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
	Route::post('/g/store/{slug}','GroupController@store')->name('group.store');
});
Route::get('/user/set_lang/{lang}','UserController@setLang')->name('user.setLang');

Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
	Route::get('/notification/index','NotificationController@index')->name('notification.index');
});

Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
	Route::get('/notification/clear','NotificationController@clear')->name('notification.clear');
});

Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
	Route::get('/user/ban/{user}/{time}','UserController@ban')->name('user.ban');
});

Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
	Route::get('/user/unban/{user}','UserController@unban')->name('user.unban');
});

Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
	Route::get('/user/banIp/{ip}','UserController@banIp')->name('user.banIp');
});

Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
	Route::get('/user/unbanIp/{ip}','UserController@unbanIp')->name('user.unbanIp');
});

Route::post('/post/tempSave','PostController@tempSave')->name('post.tempSave');

Route::get('/', function () {
    $locale = session('locale','ru');
	if($locale!='en' && $locale!='ru' && $locale!='lv'){
		$locale='ru';
	}
    //print_r($locale); exit;
    return redirect('/'.$locale);
});

Route::get('summernote',array('as'=>'summernote.get','uses'=>'FileController@getSummernote'));

Route::post('summernote',array('as'=>'summernote.post','uses'=>'FileController@postSummernote'));

//Auth::routes();



