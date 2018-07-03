<?php

//管理员管理
Route::resource('admins/admin','AdminController');

//角色管理
Route::post('admins/roles/addPermission','RolesController@addPermission')->name('addPermission');
Route::resource('admins/roles','RolesController');

//权限管理
Route::resource('admins/permission','PermissionController');