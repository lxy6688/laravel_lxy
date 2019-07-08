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

Route::get('/', function () {
    return view('welcome');    //直接定位到resources/views目录下的welcome.blade.php, 不必经过controller
});

Route::get('article', function(){
    return view('article');
});

//路由器定义的路由和controller/action关联起来
Route::get("article/index", "ArticleController@index");

/**
 * 路由分组
 * 将相同前缀特性的路由放在同一组内
 */
Route::prefix('article')->group(function(){

    Route::get("index", "ArticleController@index");
    Route::get("create", "ArticleController@create");
    Route::post("store", "ArticleController@store");

    Route::get("edit/{id}/{name}", "ArticleController@edit")->where('id','[0-9]+'); // {id},{name}是路由参数,限制id只能传递数字

});

/**
 * 随着项目扩大，需要控制器分目录
 * 创建一个app/Http/Controllers/Admin/ArticleController.php
 * php artisan make:controller Admin/ArticleController --resource
 *
 * 创建一个app/Http/Controllers/Home/ArticleController.php
 * php artisan make:controller Home/ArticleController --resource
 *
 * 路由中不需要指定多级目录，只需要指定namespace即可
 */
Route::prefix('admin/article')->namespace('Admin')->group(function(){
    Route::get("index", "ArticleController@index");
    Route::get("create", "ArticleController@create");
    Route::post("store", "ArticleController@store");
});

/**
 * 分组路由可以嵌套
 */
Route::prefix('home')->namespace('Home')->group(function(){
    Route::prefix('article')->group(function(){
        Route::get("index", "ArticleController@index");
        Route::get("create", "ArticleController@create");
        Route::post("store", "ArticleController@store");
    });
});

/**
 * 因为Admin目录下可能有多个controller文件，
 * 比如说我们再有一个 app/Http/Controllers/Admin/TagController.php
 * 那么可以用嵌套路由
 */
Route::prefix('admin')->namespace('Admin')->group(function(){
    Route::prefix('article')->group(function(){

    });
    Route::prefix('tag')->group(function(){
        Route::get("index", "TagController@index");
        Route::get("create", "TagController@create");
        Route::post("store", "TagController@store");
    });
});

/**
 * DB类 和 集合
 */
Route::prefix('database')->group(function(){
    Route::get('insert',"DatabaseController@insert");
    Route::get('get',"DatabaseController@get");
    Route::get('getCollect',"DatabaseController@getCollect");
});

/**
 * 模型 orm操作
 */
Route::prefix('model')->group(function(){
    Route::get('index',"ModelController@index");
    Route::get('get',"ModelController@get");
    Route::get('update',"ModelController@update");
    Route::get('delete',"ModelController@delete");
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
