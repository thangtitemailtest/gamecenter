<?php

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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/*API*/
Route::post('savelogs', 'ApiController@getSavelogevent')->name('get-savelogevent');
/*END API*/

Route::get('/login', 'HomeController@getLogin')->name('get-login');
Route::post('/login-post', 'HomeController@postLogin')->name('post-login');
Route::get('/logout', 'HomeController@logout')->name('get-logout');
Route::post('/thaydoithongtin-post', 'HomeController@postThaydoithongtin')->name('post-thaydoithongtin');
Route::post('/themmoiuser-post', 'HomeController@postThemmoiuser')->name('post-themmoiuser');
Route::post('/phanquyenuser-post', 'HomeController@postPhanquyenuser')->name('post-phanquyenuser');

Route::get('/khongcoquyentruycap', 'HomeController@getKhongcoquyen')->name('get-khongcoquyen');
Route::get('/thaydoithongtin', 'HomeController@getThaydoithongtin')->name('get-thaydoithongtin');

Route::middleware('Checklogin')->group(function () {
	Route::get('/', 'HomeController@getIndex')->name('get-index');

	Route::get('/danhsachuser', 'HomeController@getDanhsachuser')->name('get-danhsachuser');
	Route::get('/themmoiuser', 'HomeController@getThemmoiuser')->name('get-themmoiuser');
	Route::get('/xoauser/{id}', 'HomeController@getXoauser')->name('get-xoauser');
	Route::get('/resetpassword/{id}', 'HomeController@getResetpassword')->name('get-resetpassword');

	Route::get('/phanquyenuser/{id}', 'HomeController@getPhanquyenuser')->name('get-phanquyenuser');

	/*Report*/
	Route::group(['prefix' => 'report'], function () {
		//Route::get('/', 'chartController@index')->name('get.report');
		Route::get('/userconlaisaulevel', 'ReportController@getUserconlaisaulevel')->name('get-userconlaisaulevel');
		Route::get('/sotiencuausertheolevel', 'ReportController@getSotiencuausertheolevel')->name('get-sotiencuausertheolevel');
		Route::get('/levelusermuainapp', 'ReportController@getLevelusermuainapp')->name('get-levelusermuainapp');
		Route::get('/locsonguoichoistart', 'ReportController@getLocsonguoichoistart')->name('get-locsonguoichoistart');
		Route::get('/locsonguoichoipass', 'ReportController@getLocsonguoichoipass')->name('get-locsonguoichoipass');
		Route::get('/locsonguoichoilose', 'ReportController@getLocsonguoichoilose')->name('get-locsonguoichoilose');
		Route::get('/locsotiennguoichoipass', 'ReportController@getLocsotiennguoichoipass')->name('get-locsotiennguoichoipass');
		Route::get('/locsotiennguoichoilose', 'ReportController@getLocsotiennguoichoilose')->name('get-locsotiennguoichoilose');
		//Route::get('/locsonguoiupgradebulletlevel', 'ReportController@getLocsonguoiupgradebulletlevel')->name('get-locsonguoiupgradebulletlevel');
		//Route::get('/locsonguoiupgradebulletpower', 'ReportController@getLocsonguoiupgradebulletpower')->name('get-locsonguoiupgradebulletpower');
		Route::get('/quocgiacosologinnhieunhat', 'ReportController@getQuocgiacosologinnhieunhat')->name('get-quocgiacosologinnhieunhat');
		//Route::get('/locsonguoichoigamelandau', 'ReportController@getLocsonguoichoigamelandau')->name('get-locsonguoichoigamelandau');

		Route::get('/logevent', 'ReportController@getLogevent')->name('get-logevent');
		Route::get('/xemdanhsachlog', 'ReportController@getXemdanhsachlog')->name('get-xemdanhsachlog');


		Route::get('/testrandom', 'ReportController@testrandom')->name('get-testrandom');
	});
	/*END Report*/
});




//Auth::routes();