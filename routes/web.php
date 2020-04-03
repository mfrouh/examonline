<?php

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

Route::get('/lang/{lang}', function ($lang) {
    if(auth()->check()){
    auth()->user()->lang=$lang;
    auth()->user()->save();
    return back();
    }
    else
    {
        if(session()->get('lang'))
        {
            session()->put('lang',$lang);
            return back();
        }
    }
});

Route::group(['middleware'=>['lang']],function(){
Route::resource('exam', 'ExamController');
Route::resource('group', 'GroupController');
Route::get('/studentgroup', 'StudentgroupController@index');
Route::get('/studentgroup/create', 'StudentgroupController@create');
Route::post('/studentgroup', 'StudentgroupController@store');
Route::delete('/studentgroup/{studentgroup}', 'StudentgroupController@destroy');
Route::get('/', 'HomeController@index')->middleware('auth');
Route::get('/question', 'QuestionController@index');
Route::post('/question', 'QuestionController@store');
Route::get('/question/{id}/create', 'QuestionController@create');
Route::get('/question/{id}/{question}/edit', 'QuestionController@edit');
Route::put('/question/{question}', 'QuestionController@update');
Route::delete('/question/{question}', 'QuestionController@destroy');
Route::get('/type/{type}', 'SettingController@type');
Route::get('/show/{exam}', 'studentController@show');
Route::post('/startexam', 'studentController@startexam');
Route::get('/exams', 'studentController@exams');
Route::get('/result/{userid}/{id}', 'studentController@result');
Route::get('/studentresult/{userid}/{id}', 'TeacherController@result');
Route::get('/results', 'studentController@results');
Route::get('/waitingstudent', 'TeacherController@waitingstudent');
Route::get('/acceptstudent', 'TeacherController@acceptstudent');
Route::get('/refusedstudent', 'TeacherController@refusedstudent');
Route::post('/activestudent', 'TeacherController@activestudent');
Route::get('/results/{id}', 'TeacherController@results');
Route::get('/examdetails/{id}', 'TeacherController@examdetails');
Route::get('/detailsresult/{userid}/{id}', 'TeacherController@detailsresult');
Route::get('/students/{id}', 'TeacherController@students');
Route::post('/sessionexam', 'studentController@sessionexam');
Route::get('/myinformation', 'SettingController@myinformation')->middleware('auth');
Route::put('/information', 'SettingController@information')->middleware('auth');
Route::put('/changepassword', 'SettingController@changepassword')->middleware('auth');
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
});
