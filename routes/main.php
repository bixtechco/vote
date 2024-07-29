<?php


Route::group([
    'prefix' => '',
], function () {

    Route::get('/', 'Main\MainController@home')->name('main.main.home');

    Route::get('/login', 'App\Http\Controllers\Main\Account\LoginController@showLogin')->name('main.show-login');
    Route::post('/login', 'App\Http\Controllers\Main\Account\LoginController@login')->name('main.login');
    Route::post('/logout', 'App\Http\Controllers\Main\Account\LoginController@logout')->name('main.logout');

    Route::get('/profile', 'App\Http\Controllers\Main\Account\ProfileController@edit')->name('main.account.profile.edit');
    Route::patch('/profile', 'App\Http\Controllers\Main\Account\ProfileController@update')->name('main.account.profile.update');

    Route::get('/voting/associations', 'App\Http\Controllers\Main\Voting\AssociationsController@index')->name('main.voting.associations.list');
    Route::get('/voting/associations/create', 'App\Http\Controllers\Main\Voting\AssociationsController@create')->name('main.voting.associations.create');
    Route::post('/voting/associations', 'App\Http\Controllers\Main\Voting\AssociationsController@store')->name('main.voting.associations.store');
    Route::get('/voting/associations/{id}', 'App\Http\Controllers\Main\Voting\AssociationsController@show')->name('main.voting.associations.show');
    Route::get('/voting/associations/{id}/edit', 'App\Http\Controllers\Main\Voting\AssociationsController@edit')->name('main.voting.associations.edit');
    Route::patch('/voting/associations/{id}', 'App\Http\Controllers\Main\Voting\AssociationsController@update')->name('main.voting.associations.update');
    Route::post('/voting/associations/{id}/active', 'App\Http\Controllers\Main\Voting\AssociationsController@active')->name('main.voting.associations.active');
    Route::post('/voting/associations/{id}/inactive', 'App\Http\Controllers\Main\Voting\AssociationsController@inactive')->name('main.voting.associations.inactive');
    Route::delete('/voting/associations/{id}/delete', 'App\Http\Controllers\Main\Voting\AssociationsController@destroy')->name('main.voting.associations.destroy');

    Route::get('/voting/associations/{id}/members', 'App\Http\Controllers\Main\Voting\AssociationsController@viewMembers')->name('main.voting.associations.view-members');
    Route::get('/voting/associations/{id}/members/create', 'App\Http\Controllers\Main\Voting\AssociationsController@showAddMember')->name('main.voting.associations.show-add-member');
    Route::post('/voting/associations/{id}/members', 'App\Http\Controllers\Main\Voting\AssociationsController@addMember')->name('main.voting.associations.add-member');
    Route::delete('/voting/associations/{id}/members/{member}/delete', 'App\Http\Controllers\Main\Voting\AssociationsController@removeMember')->name('main.voting.associations.remove-member');
    Route::post('/voting/associations/{id}/members/{memberId}/admin', 'App\Http\Controllers\Main\Voting\AssociationsController@setAdmin')->name('main.voting.associations.set-admin');
    Route::post('/voting/associations/{id}/members/{memberId}/remove-admin', 'App\Http\Controllers\Main\Voting\AssociationsController@removeAdmin')->name('main.voting.associations.remove-admin');
    Route::post('/voting/associations/{id}/import-members', 'App\Http\Controllers\Main\Voting\AssociationsController@importMembers')->name('main.voting.associations.import-members');

    Route::get('/voting/associations/{id}/voting-sessions', 'App\Http\Controllers\Main\Voting\VotingSessionsController@index')->name('main.voting.voting-sessions.list');
    Route::get('/voting/associations/{id}/voting-sessions/create', 'App\Http\Controllers\Main\Voting\VotingSessionsController@create')->name('main.voting.voting-sessions.create');
    Route::post('/voting/associations/{id}/voting-sessions', 'App\Http\Controllers\Main\Voting\VotingSessionsController@store')->name('main.voting.voting-sessions.store');
    Route::get('/voting/associations/{id}/voting-sessions/{votingSession}', 'App\Http\Controllers\Main\Voting\VotingSessionsController@show')->name('main.voting.voting-sessions.show');
    Route::get('/voting/associations/{id}/voting-sessions/{votingSession}/edit', 'App\Http\Controllers\Main\Voting\VotingSessionsController@edit')->name('main.voting.voting-sessions.edit');
    Route::patch('/voting/associations/{id}/voting-sessions/{votingSession}', 'App\Http\Controllers\Main\Voting\VotingSessionsController@update')->name('main.voting.voting-sessions.update');
    Route::post('/voting/associations/{id}/voting-sessions/{votingSession}/active', 'App\Http\Controllers\Main\Voting\VotingSessionsController@active')->name('main.voting.voting-sessions.active');
    Route::post('/voting/associations/{id}/voting-sessions/{votingSession}/inactive', 'App\Http\Controllers\Main\Voting\VotingSessionsController@inactive')->name('main.voting.voting-sessions.inactive');
    Route::delete('/voting/associations/{id}/voting-sessions/{votingSession}/delete', 'App\Http\Controllers\Main\Voting\VotingSessionsController@destroy')->name('main.voting.voting-sessions.destroy');
    Route::post('/voting/associations/{id}/voting-sessions/{votingSession}/vote', 'App\Http\Controllers\Main\Voting\VotingSessionsController@vote')->name('main.voting.voting-sessions.vote');
    Route::post('/voting/associations/{id}/voting-sessions/{votingSession}/close-vote', 'App\Http\Controllers\Main\Voting\VotingSessionsController@closeVote')->name('main.voting.voting-sessions.close-vote');
    Route::get('/voting/associations/{id}/voting-sessions/{votingSession}/results', 'App\Http\Controllers\Main\Voting\VotingSessionsController@showResults')->name('main.voting.voting-sessions.show-results');
    Route::get('/voting/associations/{id}/voting-sessions/{votingSession}/admin-results', 'App\Http\Controllers\Main\Voting\VotingSessionsController@showAdminResults')->name('main.voting.voting-sessions.show-admin-results');
    Route::get('/voting/associations/{id}/voting-sessions/{votingSession}/vote/revert', 'App\Http\Controllers\Main\Voting\VotingSessionsController@revert')->name('main.voting.voting-sessions.revert');

    Route::get('/voting/voting-sessions/history', 'App\Http\Controllers\Main\Voting\VotingSessionsController@history')->name('main.voting.voting-sessions.history');


});
