<?php

Route::GET('/home', 'AdminController@index')->name('admin.home');
Route::GET('/user', 'AdminController@user')->name('admin.user');
Route::POST('/user', 'AdminController@createuser')->name('admin.createuser');
Route::POST('/user/delete/{id}', 'AdminController@deleteuser')->name('admin.deleteeuser');
Route::POST('/level', 'AdminController@level')->name('admin.level');
Route::POST('/level/delete/{id}', 'AdminController@deletelevel')->name('admin.deletelevel');

//Master skpd
Route::GET('/master/skpd', 'AdminController@masterskpd')->name('admin.masterskpd');
Route::POST('/master/skpd', 'AdminController@createmasterskpd')->name('admin.createmasterskpd');
Route::POST('/master/delete/skpd/{id}', 'AdminController@deletemasterskpd')->name('admin.deletemasterskpd');

//Master Perangkat
Route::GET('/master/perangkat', 'AdminController@masterperangkat')->name('admin.masterperangkat');
Route::POST('/master/perangkat', 'AdminController@createmasterperangkat')->name('admin.createmasterperangkat');
Route::POST('/master/delete/perangkat/{id}', 'AdminController@deletemasterperangkat')->name('admin.deletemasterperangkat');

//Inventaris
Route::GET('/inventaris', 'AdminController@inventaris')->name('admin.inventaris');
Route::POST('/inventaris', 'AdminController@createinventaris')->name('admin.createinventaris');
Route::POST('/inventaris/delete/{id}', 'AdminController@deleteinvetaris')->name('admin.deleteinvetaris');

//Laporan
Route::GET('/laporan', 'AdminController@laporan')->name('admin.laporan');
Route::POST('/laporan/print/{id}', 'AdminController@laporanprint')->name('admin.laporan.laporanprint');



// Login and Logout
Route::GET('/', 'LoginController@showLoginForm')->name('admin.login');
Route::POST('/', 'LoginController@login');
Route::POST('/logout', 'LoginController@logout')->name('admin.logout');

// Password Resets
Route::POST('/password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
Route::GET('/password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
Route::POST('/password/reset', 'ResetPasswordController@reset');
Route::GET('/password/reset/{token}', 'ResetPasswordController@showResetForm')->name('admin.password.reset');
Route::GET('/password/change', 'AdminController@showChangePasswordForm')->name('admin.password.change');
Route::POST('/password/change', 'AdminController@changePassword');

// Register Admins
Route::get('/register', 'RegisterController@showRegistrationForm')->name('admin.register');
Route::post('/register', 'RegisterController@register');
Route::get('/{admin}/edit', 'RegisterController@edit')->name('admin.edit');
Route::delete('/{admin}', 'RegisterController@destroy')->name('admin.delete');
Route::patch('/{admin}', 'RegisterController@update')->name('admin.update');

// Admin Lists
Route::get('/show', 'AdminController@show')->name('admin.show');
Route::get('/me', 'AdminController@me')->name('admin.me');

// Admin Roles
Route::post('/{admin}/role/{role}', 'AdminRoleController@attach')->name('admin.attach.roles');
Route::delete('/{admin}/role/{role}', 'AdminRoleController@detach');

// Roles
Route::get('/roles', 'RoleController@index')->name('admin.roles');
Route::get('/role/create', 'RoleController@create')->name('admin.role.create');
Route::post('/role/store', 'RoleController@store')->name('admin.role.store');
Route::delete('/role/{role}', 'RoleController@destroy')->name('admin.role.delete');
Route::get('/role/{role}/edit', 'RoleController@edit')->name('admin.role.edit');
Route::patch('/role/{role}', 'RoleController@update')->name('admin.role.update');

// active status
Route::post('activation/{admin}', 'ActivationController@activate')->name('admin.activation');
Route::delete('activation/{admin}', 'ActivationController@deactivate');
Route::resource('permission', 'PermissionController');

Route::fallback(function () {
    return abort(404);
});
