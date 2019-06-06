<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::group(['middleware' => 'install'], function() {
    Route::get('/', ['as' => 'main', 'uses' => 'MainController@redirect']);
    Route::get('locale/{locale}', ['as' => 'change_locale', 'uses' => 'MainController@changeLocale']);

    // Login
    Route::get('login', ['as' => 'get_login', 'uses' => 'Auth\LoginController@showLoginForm']);
    Route::post('login', ['as' => 'post_login', 'uses' => 'Auth\LoginController@login']);

    // Forgot Password
    Route::get('password/email', ['as' => 'get_email', 'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm']);
    Route::post('password/email', ['as' => 'post_email', 'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail']);

    // Reset Password
    Route::get('password/reset/{token}', ['as' => 'get_reset', 'uses' => 'Auth\ResetPasswordController@showResetForm']);
    Route::post('password/reset', ['as' => 'post_reset', 'uses' => 'Auth\ResetPasswordController@reset']);

    // Add to Queue
    Route::get('queue', ['as' => 'add_to_queue', 'uses' => 'AddToQueueController@index']);
    Route::post('queue', ['as' => 'post_add_to_queue', 'uses' => 'AddToQueueController@postDept']);
    Route::post('refreshToken', ['as' => 'refresh_token', 'uses' => 'AddToQueueController@refreshToken']);
    Route::post('queue/getQPriority', ['as' => 'post_cuhid', 'uses' => 'AddToQueueController@getQPriority']);

    // Display
    Route::get('display', ['as' => 'display', 'uses' => 'DisplayController@index']);
    Route::get('display/test/', ['as' => 'test', 'uses' => 'DisplayController@test']);
    Route::post('display/autoCall', ['as' => 'auto_call', 'uses' => 'DisplayController@autoCall']);
    Route::get('display/testlift/', ['as' => 'test_lift', 'uses' => 'DisplayController@testlift']);

    // Display Second
    Route::get('displaysecond', ['as' => 'displaysecond', 'uses' => 'DisplaySecondController@index']);
    Route::get('displaysecond/test/', ['as' => 'test', 'uses' => 'DisplaySecondController@test']);
    Route::post('displaysecond/autoCall', ['as' => 'auto_call', 'uses' => 'DisplaySecondController@autoCall']);
    Route::get('displaysecond/testlift/', ['as' => 'test_lift', 'uses' => 'DisplaySecondController@testlift']);
   
   

    // Authenticated
	Route::group(['middleware' => 'auth:users'], function() {
        // Logout
		Route::post('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

		// Dashboard
		Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);
        Route::post('dashboard/settings', ['as' => 'dashboard_store', 'uses' => 'DashboardController@store']);
		Route::get('dashboard/startCounter/{call_id}', ['as' => 'startCounter', 'uses' => 'DashboardController@startCounter']);
        Route::get('dashboard/endCounter/{call_id}', ['as' => 'endCounter', 'uses' => 'DashboardController@endCounter']);
        Route::post('dashboard/doctorDirectCall', ['as' => 'post_doctor_call', 'uses' => 'DashboardController@doctorDirectCall']);
        Route::get('dashboard/PatientStatus/{user}', ['as' => 'PatientStatus', 'uses' => 'DashboardController@PatientStatus']);
        Route::post('dashboard/DoctorviewStatus', ['as' => 'post_doctor_status', 'uses' => 'DashboardController@DoctorviewStatus']);

        Route::post('dashboard/scannerDirectCall', ['as' => 'post_scanner_call', 'uses' => 'DashboardController@scannerDirectCall']);

        // Calls
        Route::get('calls', ['as' => 'calls', 'uses' => 'CallController@index']);
        Route::post('calls', ['as' => 'post_call', 'uses' => 'CallController@newCall']);
        Route::post('calls/recall', ['as' => 'post_recall', 'uses' => 'CallController@recall']);
        Route::post('calls/dept/{department}', ['as' => 'post_dept', 'uses' => 'CallController@postDept']);
        Route::post('calls/pdept', ['as' => 'post_pdept', 'uses' => 'CallController@postPdept']);
        Route::post('calls/getPriority', ['as' => 'post_uhid', 'uses' => 'CallController@getPriority']);
        Route::get('calls/newToken', ['as' => 'new_Token', 'uses' => 'CallController@newToken']);
        Route::post('calls/newtoken/{id}', ['as' => 'new_tokeng', 'uses' => 'CallController@newTokenGenerator']);
        Route::get('calls/printToken', ['as' => 'print_Token', 'uses' => 'CallController@printToken']);
        Route::get('calls/rePrintToken/{id}', ['as' => 'reprint_token', 'uses' => 'CallController@rePrintToken']);
        Route::post('calls/getBarcode', ['as' => 'post_barcode', 'uses' => 'CallController@getBarcode']);
		
		//Export
		Route::get('exports', ['as' => 'exports', 'uses' => 'ExportController@index']);
		
        // Department
        Route::resource('departments', 'DepartmentController', ['except' => ['show']]);
		
		// Parent Department
        Route::resource('parent_departments', 'ParentDepartmentController', ['except' => ['show']]);

        // Counter
        Route::resource('counters', 'CounterController', ['except' => ['show']]);
        Route::post('counters/spdept', ['as' => 'post_mpdept', 'uses' => 'CounterController@postMpDept']);

        //Reports
        Route::group(['prefix' => 'reports', 'as' => 'reports::'], function() {
            // User Report
             Route::get('user', ['as' => 'user', 'uses' => 'UserReportController@index']);
            Route::get('user/{user}/{sdate}/{edate}', ['as' => 'user_show', 'uses' => 'UserReportController@show']);
            Route::get('user/{asdate}/{aedate}', ['as' => 'doctor_show', 'uses' => 'UserReportController@showrecord']);

            // Queue list
            Route::get('queuelist/{date}', ['as' => 'queue_list', 'uses' => 'QueueListReportController@index']);

            // Monthly Report
            Route::get('monthly', ['as' => 'monthly', 'uses' => 'MonthlyReportController@index']);
            Route::get('monthly/{department}/{sdate}/{edate}', ['as' => 'monthly_show', 'uses' => 'MonthlyReportController@show']);

            // Statistical Report
            Route::get('statistical', ['as' => 'statistical', 'uses' => 'StatisticalReportController@index']);
            Route::get('statistical/{date}/{user}/{department}/{counter}', ['as' => 'statistical_show', 'uses' => 'StatisticalReportController@show']);

            // Missed
            Route::get('missed-overtime', ['as' => 'missed', 'uses' => 'MissedOvertimeReportController@index']);
            Route::get('missed-overtime/{date}/{user}/{counter}/{type}', ['as' => 'missed_show', 'uses' => 'MissedOvertimeReportController@show']);
        });

        // Users
        Route::get('users/{user}/password', ['as' => 'get_user_password', 'uses' => 'UserController@getPassword']);
        Route::post('users/{user}/password', ['as' => 'post_user_password', 'uses' => 'UserController@postPassword']);
        Route::post('users/updept', ['as' => 'post_updept', 'uses' => 'UserController@postUpDept']);
        Route::resource('users', 'UserController', ['except' => ['show', 'edit', 'update']]);
        Route::get('users/updateStatus/{user}', ['as' => 'update_status', 'uses' => 'UserController@updateStatus']);
        
        

        // Settings
        Route::get('settings', ['as' => 'settings', 'uses' => 'SettingsController@index']);
        Route::post('settings', ['as' => 'post_settings', 'uses' => 'SettingsController@update']);
        Route::post('settings/company', ['as' => 'post_company', 'uses' => 'SettingsController@companyUpdate']);
        Route::post('settings/overmissed', ['as' => 'post_over_missed', 'uses' => 'SettingsController@overmissedUpdate']);
        Route::post('settings/locale', ['as' => 'post_locale', 'uses' => 'SettingsController@localeUpdate']);
        Route::get('settings/assignroom/{user}', ['as' => 'assignroom', 'uses' => 'SettingsController@assignroom']);
		
		Route::post('settings/mapDept', ['as' => 'post_map_dept', 'uses' => 'SettingsController@mapDept']);
        Route::post('settings/spdept', ['as' => 'post_spdept', 'uses' => 'SettingsController@postPdept']);
        Route::post('settings/cgdept', ['as' => 'post_cgdept', 'uses' => 'SettingsController@postCgdept']);
        Route::post('settings/cuserdept', ['as' => 'post_cuserdept', 'uses' => 'SettingsController@postUserdept']);
        //Route::get('settings/{user}/doctormap', ['as' => 'get_doctor_mapdept', 'uses' => 'SettingsController@getMapDoctor']);
    });
});
