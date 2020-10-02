<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::post('/board/post-group', 'GroupController@postGroup');
// TODO: MOVE TO AUTH
Route::post('/board/set-board-admin', 'BoardController@setBaordAdmin');

Route::get('/saber', 'saber@index');
Route::get('/', ['middleware' => 'guest', 'uses' => 'UserController@getLogin', 'as' => 'auth.login',]);
Route::get('login', ['middleware' => 'guest', 'uses' => 'UserController@getLogin', 'as' => 'auth.login',]);
Route::post('login', ['middleware' => 'guest', 'uses' => 'UserController@postLogin',])->name('login');
//Route::get('password/reset/{token?}', ['middleware' => 'guest', 'uses' => 'UserController@reset',]);
//Route::post('password/reset', ['middleware' => 'guest', 'uses' => 'UserController@resetPassword',]);
Route::get('logout', function () {
    Auth::logout();
    return redirect('/');
});
Route::get('register', ['middleware' => 'guest', 'uses' => 'UserController@getRegister', 'as' => 'auth.register',]);
Route::post('register', ['middleware' => 'guest', 'uses' => 'UserController@postRegister',]);
Route::get('dashboard', ['middleware' => 'auth', 'uses' => 'UserController@getDashboard', 'as' => 'user.dashboard',]);
Route::get('profile', ['middleware' => 'auth', 'uses' => 'UserController@getProfile', 'as' => 'user.profile',]);
Route::get('activity', ['middleware' => 'auth', 'uses' => 'UserActivityController@getUserActivity', 'as' => 'user.activity',]);

Route::get('setting', ['middleware' => 'auth', 'uses' => 'UserActivityController@getUserSetting', 'as' => 'user.setting',]);


// todo: DUPLICATE ROUTE
Route::post('postBoard', ['middleware' => 'auth', 'uses' => 'BoardController@postBoard',]);
Route::post('update-board-favourite', ['middleware' => 'auth', 'uses' => 'BoardController@updateBoardFavourite',]);

/**
 * Board
 */
Route::group(
    ['prefix' => 'board'],
    function () {
        Route::post('/postListName', ['uses' => 'ListController@postListName',]);
        Route::post('/delete-list', ['uses' => 'ListController@deleteList',]);
        Route::post('/update-list-name', ['uses' => 'ListController@updateListName',]);

        Route::post('/postCard', ['uses' => 'CardController@postCard',]);
        Route::post('/changeCardList', ['uses' => 'CardController@changeCardList',]);
        Route::post('/deleteCard', ['uses' => 'CardController@deleteCard',]);
        Route::post('/getCardDetail', ['uses' => 'CardController@getCardDetail',]); //card_task
        Route::post('/update-card-data', ['uses' => 'CardController@updateCardData',]);

        Route::post('/save-comment', ['uses' => 'CommentController@saveComment',]);

        Route::post('/save-task', ['uses' => 'TaskController@saveTask',]);
        Route::post('/delete-task', ['uses' => 'TaskController@deleteTask',]);
        Route::post('/update-task-completed', ['uses' => 'TaskController@updateTaskCompleted',]);

        Route::get('/{id?}', ['middleware' => 'auth', 'uses' => 'BoardController@getBoardDetail', 'as' => 'user.boardDetail',]);

        Route::post('create-user-activity', ['uses' => 'UserActivityController@createUserActivity']);

        Route::post('/create-board-member', ['uses' => 'BoardMemberController@create',]);
        Route::post('postBoard', ['middleware' => 'auth', 'uses' => 'BoardController@postBoard',]);
    }
);

/**
 * Password Reset
 */
Route::group(
    ['prefix' => 'password'],
    function () {
        // Password reset link request routes...
        Route::get('/email', 'Auth\PasswordController@getEmail');
        Route::post('/email', 'Auth\PasswordController@postEmail');

        // Password reset routes...
        Route::get('/reset/{token}', 'Auth\PasswordController@getReset');
        Route::post('/reset', 'Auth\PasswordController@postReset');
    }
);

Route::post('create-user-activity', ['uses' => 'UserActivityController@createUserActivity']);


Route::get('/reports', 'ReportController@index');
