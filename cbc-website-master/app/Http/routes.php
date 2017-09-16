<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::controller('/facebook', 'FacebookController');
Route::get('/pictures/{name}', 'PicturesController@getIndex');
Route::controller('/backoffice/translation', 'TranslationMatchController');
Route::controller('/backoffice/validation', 'ValidationController');
Route::controller('/backoffice/experience', 'AdminExperienceController');
Route::controller('/backOffice', 'BackOfficeController');
Route::controller('/experiences', 'ExperienceController');
Route::controller('/page', 'PageController');
Route::controller('/user/articles','ArticleController');
Route::controller('/user/bookings','BookingController');
Route::controller('/user/analytics','AnalyticController');
Route::controller('/profile', 'ProfileController');
Route::controller('/language', 'LanguageController');
Route::controller('/tag', 'TagController');
Route::controller('/user', 'AccountController');
Route::controller('/cron', 'CronController');
Route::get('/search/{query?}/{suffix?}', 'SearchController@getSearch');
Route::controller('/', 'WelcomeController');