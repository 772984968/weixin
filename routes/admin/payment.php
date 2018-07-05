<?php
Route::any('getTitle','PaymentController@getTitle')->name('payment.getTitle');
Route::resource('payment','PaymentController');
