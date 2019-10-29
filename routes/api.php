<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'auth'], function () {
    Route::post('login','AuthController@authenticate');
    Route::post('register','AuthController@authenticate');
    Route::get('logout','AuthController@logout');
    Route::get('check','AuthController@check');
});

// session route
Route::post('email-exist',[
    'as' => 'email-exist','uses' => 'Demo\PagesController@emailExist'
]);

Route::group(['prefix' => 'admin'], function(){
    Route::get('products/',[
        'as' => 'admin.products', 'uses' => 'ProductController@index'
    ]);
});

// admin route
Route::group(['prefix' => 'admin', 'middleware' => 'api.auth'], function (){

    Route::group(['prefix' => 'analysis'], function () {
        Route::get('/filterInformation',[
            'as' => 'admin.analysis.filters', 'uses' => 'AnalysisController@getFilterInformation'
        ]);
        Route::get('/subjectPlotData',[
            'as' => 'admin.analysis.subjectPlotData', 'uses' => 'AnalysisController@subjectPlotData'
        ]);
        Route::get('/subjectBoxData',[
            'as' => 'admin.analysis.subjectBoxData', 'uses' => 'AnalysisController@subjectBoxData'
        ]);
        Route::get('/marksData',[
            'as' => 'admin.analysis.marksData', 'uses' => 'AnalysisController@marksData'
        ]);
    });

    Route::group(['prefix' => 'users'], function (){

        Route::get('/get',[
            'as' => 'admin.users', 'uses' => 'Demo\PagesController@allUsers'
        ]);

        Route::delete('/{id}',[
            'as' => 'admin.users.delete', 'uses' => 'Demo\PagesController@destroy'
        ]);

    });

});

Route::post('imageUpload','ImageController@imageUpload');

