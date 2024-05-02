<?php


Route::group([
    'prefix' => '',
], function () {

    Route::get('/', 'Main\MainController@home')->name('main.main.home');

    Route::get('/account/login', 'App\Http\Controllers\Main\Account\LoginController@showLogin')->name('main.show-login');
    Route::post('/login', 'App\Http\Controllers\Main\Account\LoginController@login')->name('main.login');
    Route::post('/logout', 'App\Http\Controllers\Main\Account\LoginController@logout')->name('main.logout');

    Route::get('/voting/associations', 'App\Http\Controllers\Main\Voting\AssociationsController@index')->name('main.voting.associations.list');
    Route::get('/voting/associations/create', 'App\Http\Controllers\Main\Voting\AssociationsController@create')->name('main.voting.associations.create');
    Route::post('/voting/associations', 'App\Http\Controllers\Main\Voting\AssociationsController@store')->name('main.voting.associations.store');
    Route::get('/voting/associations/{id}', 'App\Http\Controllers\Main\Voting\AssociationsController@show')->name('main.voting.associations.show');
    Route::get('/voting/associations/{id}/edit', 'App\Http\Controllers\Main\Voting\AssociationsController@edit')->name('main.voting.associations.edit');
    Route::post('/voting/associations/{id}', 'App\Http\Controllers\Main\Voting\AssociationsController@update')->name('main.voting.associations.update');


});
