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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/','FrontPageController@login');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/glavna','FrontPageController@index');

Route::get('/izmeniPodatkeUser','UserChangeController@changeUser')->middleware('auth');
Route::get('/izmeniLozinku','ChangePasswordController@changePassForm')->middleware('auth');
Route::post('/madeChangeUser','UserChangeController@madeChangeUser')->middleware('auth');
Route::post('/changePassword','ChangePasswordController@changePassword')->middleware('auth');


Route::prefix('/admin')->middleware('admin')->group(function()
{
    Route::get('/','AdminController@home');
    Route::get('/roleChange/{id}','AdminController@formaRole');
    Route::post('/change','AdminController@change');
    Route::get('/delete/{id}','AdminController@delete');
    
});

Route::get('/test', 'FrontPageController@test');

Route::prefix('/lekar')->middleware('doktor')->group(function()
{
    Route::get('/','DoctorController@index');
    Route::get('/chart/{id}','ChartController@showChart');
    Route::get('/visit/{id}','VisitController@createVisit');
    Route::post('/storeVisit','VisitController@storeVisit');
    Route::get('/editChart/{id}','ChartController@editChart');
    Route::post('/updateChart','ChartController@updateChart');
    Route::get('/editTreatmant/{id}','PartVisitController@editTreatmant');
    Route::post('/updateTreatmant','PartVisitController@updateTreatmant');
    Route::post('/updateTreatmantReact','PartVisitController@updateTreatmantReact');
    Route::get('/editVisit/{id}','VisitController@editVisit');
    Route::post('/updateVisit','VisitController@updateVisit');
    Route::get('/createTreatmant/{list}','PartVisitController@createTreatmant');
    Route::post('/storeTreatmant','PartVisitController@storeTreatmant');
    Route::get('/destroyVisit/{list}','VisitController@destroyVisit'); 
    Route::get('/showSingleVisitJSON/{list}','VisitController@showSingleVisitJSON');
    Route::get('/getCodes','VisitController@getCodes');
});

Route::prefix('/osoblje')->middleware('osoblje')->group(function()
{
    Route::get('/','AssistController@index');
    Route::get('/create','AssistController@create');
    Route::post('/store','AssistController@store');
    Route::get('/edit/{id}','AssistController@edit');
    Route::post('/update','AssistController@update');
    Route::get('/destroy/{id}','AssistController@destroy');
});

Route::get('/lekovi','CureController@index')->middleware('dokt_osob');

Route::prefix('/lekovi')->middleware('osoblje')->group(function()
{
    Route::get('/curesByAmount','CureController@curesByAmount');
    Route::get('/create','CureController@create');
    Route::post('/store','CureController@store');
    Route::get('/edit/{id}','CureController@edit');
    Route::post('/update','CureController@update');
    Route::get('/destroy/{id}','CureController@destroy');
});

Route::get('/bolesti','DiseaseController@index')->middleware('dokt_osob');

Route::prefix('/bolesti')->middleware('osoblje')->group(function()
{
    Route::get('/create','DiseaseController@create');
    Route::post('/store','DiseaseController@store');
    Route::get('/edit/{id}','DiseaseController@edit');
    Route::post('/update','DiseaseController@update');
    Route::get('/destroy/{id}','DiseaseController@destroy');
});

Route::get('/createDataJSON','ReactSupportController@createDataJSON');
Route::get('/reactAPI','ReactSupportController@reactAPI');
Route::get('/kartoniStranica','ReactSupportController@kartoniStranica');

