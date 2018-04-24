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
Route::pattern("slug", "(.*)");
Route::pattern("id", "([0-9]*)");
/*
Route::get('/', function () {
return view('welcome');
});
 */
//login

Route::group(['namespace' => 'Auth', 'prefix' => 'admin'], function () {
    Route::get('login', [
        'uses' => 'AuthController@getLogin',
        'as' => 'admin.user.getlogin',
    ]);

    Route::post('login', [
        'uses' => 'AuthController@postLogin',
        'as' => 'admin.user.postlogin',
    ]);

    Route::get('logout', [
        'uses' => 'AuthController@logout',
        'as' => 'admin.user.logout',
    ]);

    Route::post('getpassword', [
        'uses' => 'AuthController@postPass',
        'as' => 'admin.user.postpass',
    ]);

    Route::get('confirm-{id}', [
        'uses' => 'AuthController@getConfirm',
        'as' => 'admin.user.getConfirm',
    ]);

    Route::post('confirm-{id}', [
        'uses' => 'AuthController@postConfirm',
        'as' => 'admin.user.postConfirm',
    ]);

    Route::get('newpass-{id}', [
        'uses' => 'AuthController@getNewPass',
        'as' => 'admin.user.getnewpass',
    ]);

    Route::post('password-{id}', [
        'uses' => 'AuthController@done',
        'as' => 'admin.user.postdonepass',
    ]);

});

//admin

Route::group(['namespace' => "Admin", 'prefix' => 'admin', 'middleware' => 'auth'], function () {

    //index sx lich
    Route::group(["prefix" => "calendar"], function () {

        Route::get('', [
            'uses' => 'LichController@index',
            'as' => 'admin.calendar.index',
        ]);

        Route::get('/export', [
            'uses' => 'LichController@export',
            'as' => 'admin.calendar.export',
        ]);

        Route::post('', [
            'uses' => 'LichController@run',
            'as' => 'admin.calendar.calendar',
        ]);

        Route::get('/show', [
            'uses' => 'LichController@show',
            'as' => 'admin.calendar.show',
        ]);

    });

    //quản lí user
    Route::group(["prefix" => "user"], function () {
        Route::get('active/{nid}', 'UserController@trangThai');

        Route::get('', [
            'uses' => 'UserController@index',
            'as' => 'admin.user.index',
        ]);

        Route::get('add', [
            'uses' => 'UserController@getAdd',
            'as' => 'admin.user.getadd',
        ]);

        Route::post('add', [
            'uses' => 'UserController@postAdd',
            'as' => 'admin.user.postadd',
        ]);

        Route::get('edit/{id}', [
            'uses' => 'UserController@getEdit',
            'as' => 'admin.user.getedit',
        ]);

        Route::post('edit/{id}', [
            'uses' => 'UserController@postEdit',
            'as' => 'admin.user.postedit',
        ]);

        Route::post('del', [
            'uses' => 'UserController@del',
            'as' => 'admin.user.del',
        ])->middleware("role:admin");

    });

//REFEREE
    Route::group(["prefix" => "referee"], function () {
        Route::get('active/{nid}', 'TrongTaiController@trangThai');

        Route::get('', [
            'uses' => 'TrongTaiController@index',
            'as' => 'admin.referee.index',
        ]);

        Route::get('add', [
            'uses' => 'TrongTaiController@getAdd',
            'as' => 'admin.referee.getadd',
        ]);

        Route::post('add', [
            'uses' => 'TrongTaiController@postAdd',
            'as' => 'admin.referee.postadd',
        ]);

        Route::get('edit/{id}', [
            'uses' => 'TrongTaiController@getEdit',
            'as' => 'admin.referee.getedit',
        ]);

        Route::post('edit/{id}', [
            'uses' => 'TrongTaiController@postEdit',
            'as' => 'admin.referee.postedit',
        ]);

        Route::post('del', [
            'uses' => 'TrongTaiController@del',
            'as' => 'admin.referee.del',
        ])->middleware("role:admin");

    });

//Cau Thu
    Route::group(["prefix" => "player"], function () {
        Route::get('active/{nid}', 'CauThuController@trangThai');

        Route::get('', [
            'uses' => 'CauThuController@index',
            'as' => 'admin.player.index',
        ]);

        Route::get('add', [
            'uses' => 'CauThuController@getAdd',
            'as' => 'admin.player.getadd',
        ]);

        Route::post('add', [
            'uses' => 'CauThuController@postAdd',
            'as' => 'admin.player.postadd',
        ]);

        Route::get('edit/{cauThu}', [
            'uses' => 'CauThuController@getEdit',
            'as' => 'admin.player.getedit',
        ])->where('{cauThu}', '[0-9]+');

        Route::post('edit/{id}', [
            'uses' => 'CauThuController@postEdit',
            'as' => 'admin.player.postedit',
        ]);

        Route::post('del', [
            'uses' => 'CauThuController@del',
            'as' => 'admin.player.del',
        ])->middleware("role:admin");

    });

//Football
    Route::group(["prefix" => "football"], function () {
        Route::get('active/{nid}', 'DoiBongController@trangThai');

        Route::get('', [
            'uses' => 'DoiBongController@index',
            'as' => 'admin.football.index',
        ]);

        Route::get('add', [
            'uses' => 'DoiBongController@export',
            'as' => 'admin.football.getadd',
        ]);

        Route::post('add', [
            'uses' => 'DoiBongController@postAdd',
            'as' => 'admin.football.postadd',
        ]);

        Route::get('edit/{doiBong}', [
            'uses' => 'DoiBongController@getEdit',
            'as' => 'admin.football.getedit',
        ])->where('{doiBong}', '[0-9]+');

        Route::post('edit/{id}', [
            'uses' => 'DoiBongController@postEdit',
            'as' => 'admin.football.postedit',
        ]);

        Route::post('del', [
            'uses' => 'DoiBongController@del',
            'as' => 'admin.football.del',
        ])->middleware("role:admin");

    });

//UPDATE
    Route::group(["prefix" => "update"], function () {
        Route::get("/", [
            'uses' => 'UpdateController@index',
            'as' => 'admin.update.index',
        ]);

        Route::post("/search", [
            'uses' => 'UpdateController@search',
            'as' => 'admin.update.search',
        ]);

        Route::post("/{id}", [
            'uses' => 'UpdateController@update',
            'as' => 'admin.update.update',
        ])->where('id', '[0-9]+');

        Route::get("/{round}", [
            'uses' => 'UpdateController@show',
            'as' => 'admin.update.show',
        ])->where('round', '[0-9]+');
    });

});
Route::get('error', function () {
    return view('errors.404');
});
Route::get('permission', function () {

    return view('errors.loi');
});
