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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/profile', 'UserController@getUserProfile');

Route::post('/update_profile', 'UserController@updateUserProfile');

Route::get('/get_profiles', 'UserController@getAllProfiles');

Route::post('/edit_profile_admin', 'UserController@editSelectedProfile');

Route::post('/update_profile_admin', 'UserController@adminUpdateSelectedProfile');

Route::post('/suspend_profile_admin', 'UserController@adminSuspendProfile');

Route::post('/delete_profile_admin', 'UserController@adminDeleteProfile');

Route::get('/get_portfolio', 'UserController@getPortfolio');

Route::post('/update_portfolio', 'UserController@updatePortfolio');

Route::post('/edit_portfolio_admin', 'UserController@adminEditPortfolio');

Route::post('/update_portfolio_admin', 'UserController@adminUpdatePortfolio');

Route::get('/get_jobs', 'UserController@getAllJobs');

Route::post('/delete_portfolio', 'UserController@deletePortfolio');

Route::get('/get_groups', 'UserController@getAllGroups');

Route::post('/delete_group', 'UserController@deleteGroup');

Route::post('/edit_group', 'UserController@editGroup');

Route::post('/update_group', 'UserController@updateGroup');

Route::post('/create_group', 'UserController@createGroup');

Route::get('/get_create_group', 'UserController@getCreateGroup');

Route::post('/join_group', 'UserController@joinGroup');

Route::post('/leave_group', 'UserController@leaveGroup');

Route::post('/get_jobs_search', 'UserController@getJobsBySearch');

Route::post('/view_job', 'UserController@viewJob');















