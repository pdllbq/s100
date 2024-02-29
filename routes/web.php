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

Route::get('/test/index','TestController@index')->name('test.index');

Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
	Route::get('/login/facebook', 'Auth\LoginController@redirectToFacebook');
});
Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
	Route::get('/login/facebook/callback', 'Auth\LoginController@redirectToFacebook');
});
Route::get('/login/facebook/callback', 'Auth\LoginController@handleFacebookCallback');

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
  Route::get('sandbox','PostController@sandbox')->name('post.sandbox');
});
Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
  Route::get('readed','PostController@readed')->name('post.readed');
});
Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
  Route::get('i_like','PostController@iLike')->name('post.iLike');
});
Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
  Route::get('moder','PostController@moderation')->name('post.moder');
});
Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
  Route::get('draft','PostController@draft')->name('post.draft');
});
Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
  Route::get('/post/{slug}/to_sandbox','PostController@toSandbox')->name('post.toSandbox');
});
Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
  Route::get('/post/{slug}/leave_in_sandbox','PostController@leaveInSandbox')->name('post.leaveInSandbox');
});
Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
  Route::get('/post/{slug}/from_sandbox','PostController@fromSandbox')->name('post.fromSandbox');
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

//rss
Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
  Route::get('/rss','PostController@rss')->name('rss');
});

Route::get('/tag/{tag}','PostController@preTag')->name('post.preTag');
Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
  Route::get('/tag/{tag}','PostController@tag')->name('post.tag');
});

//lang group
Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
  //Admin
  Route::get('/admin','AdminController@index')->name('admin.index');
  Route::get('/admin/news','AdminController@news')->name('admin.news');
  Route::post('/admin/news/store','AdminController@newsStore')->name('admin.news.store');
  Route::post('/admin/news/update','AdminController@newsUpdate')->name('admin.news.update');
  Route::get('/admin/news/delete/{id}','AdminController@newsDelete')->name('admin.news.delete');
  Route::get('/admin/news/filters','AdminController@newsFilters')->name('admin.news.filters');
  Route::post('/admin/news/filters/store','AdminController@newsFiltersStore')->name('admin.news.filters.store');
  Route::post('/admin/news/filters/update','AdminController@newsFiltersUpdate')->name('admin.news.filters.update');
  Route::get('/admin/news/filters/delete/{id}','AdminController@newsFiltersDelete')->name('admin.news.filters.delete');
  Route::post('/admin/news/filters/words/store','AdminController@newsFiltersWordsStore')->name('admin.news.filters.words.store');
  Route::get('/admin/news/list','AdminController@newsList')->name('admin.news.list');
  //
});

//News
Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
  Route::get('/news','NewsController@index')->name('news.index');
  Route::get('/news/{filteSlug}','NewsController@filter')->name('news.filter');
});

Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
  Route::get('{slug}','PostController@oldShow')->name('post.oldShow');
});

Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
  Route::get('/r/{groupSlugOrUserName}/{slug}','PostController@show')->name('post.show');
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
  Route::get('/user/withdrawl','UserController@withdrawl')->name('user.withdrawl');
});

Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
  Route::get('/user/withdrawl_save','UserController@withdrawlSave')->name('user.withdrawlSave');
});

Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
  Route::get('/user/show_referrals','UserController@showReferrals')->name('user.showReferrals');
});

Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
  Route::get('/user/withdrawl_moderation','UserController@withdrawlModeration')->name('user.withdrawlModeration');
});

Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
  Route::get('/user/withdrawl_withdrawed/{id}','UserController@withdrawlWithdrawed')->name('user.withdrawlWithdrawed');
});

Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
  Route::get('/user/withdrawl_return_to_balance/{id}','UserController@withdrawlReturnToBalance')->name('user.withdrawlReturnToBalance');
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

Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
	Route::post('/password/new','\App\Http\Controllers\Auth\ResetPasswordController@newPassword')->name('password.newPassword');
});

Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
	Route::get('/brivdienu-kalendars/{year}','HolidayCalendarController@index')->name('holidayCalendar');
});

Route::group(['prefix'=>'{locale}','middleware'=>'setlocale'],function(){
	Route::post('/password/new_save','\App\Http\Controllers\Auth\ResetPasswordController@saveNewPassword')->name('password.saveNewPassword');
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

Route::get('/embed/tiktok/{userName}/{videoId}','EmbedController@tiktok')->name('embed.tiktok');

Route::get('/embed/youtube/{videoId}','EmbedController@youtube')->name('embed.youtube');

Route::get('/embed/telegram/{groupName}/{postId}','EmbedController@telegram')->name('embed.telegram');

Route::get('summernote',array('as'=>'summernote.get','uses'=>'FileController@getSummernote'));

Route::post('summernote',array('as'=>'summernote.post','uses'=>'FileController@postSummernote'));

//Auth::routes();
