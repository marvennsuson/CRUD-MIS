<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return redirect('login');
});

Route::get('/email', function () {
    return (new App\Notifications\UserElectronicReceipt('lols'))
                ->toMail('niellevince@gmail.com');
});

Route::get('/test-email', 'ApplicationController@sendReceipt');

// Authentication
Auth::routes();
Route::get('/forgot-password', function () {
    return view('auth.passwords.email');
})->name('forgot-password');
Route::post('/password/reset', 'Auth\ResetPasswordController@updatepassword')->name('password.update');

Route::get('/admin/login', 'Auth\LoginController@showAdminLogin')->name('admin.login');
Route::post('/login', 'Auth\LoginController@authenticate')->name('login');
Route::post('/admin/login', 'Auth\LoginController@adminAuth')->name('admin.login');

// Admin
Route::get('/admin', function () {
    return redirect(route('admin.login'));
});
Route::middleware('auth', 'admin')->prefix('/admin')->group(function(){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/Admin', 'UserController@userList')->name('admin.users_list');

    Route::post('/users/add', 'UserController@userCreate')->name('admin.users.add');
    Route::post('/users/edit', 'UserController@showEditForm')->name('admin.users.edit');

    Route::put('/users/update', 'UserController@updateUser')->name('admin.users.update');

    Route::post('/users/delete', 'UserController@deleteUser')->name('admin.users.delete');
    Route::get('/users/generated', 'UserController@AdmingeneratedData')->name('admin.users.generated');
    Route::get('/users/show/{id?}', 'UserController@showEditForm')->name('admin.users.show');
    Route::get('/usergroups', 'UserGroupController@list')->name('admin.usergroup');

    Route::post('/usergroups/add', 'UserGroupController@add')->name('admin.usergroup.add');
    Route::post('/usergroups/edit', 'UserGroupController@showEditForm')->name('admin.usergroup.edit');
    Route::put('/usergroups/update', 'UserGroupController@update')->name('admin.usergroup.update');
    Route::post('/usergroups/delete', 'UserGroupController@delete')->name('admin.usergroup.delete');
    
    Route::get('/profile', 'admin\AdminController@Profile')->name('admin.profile');
    Route::put('/update', 'admin\AdminController@UpdateProfile')->name('admin.update.profile');

    Route::get('/Residents', 'admin\UserController@index')->name('user.residentlist');
    Route::get('/Residents/generated', 'admin\UserController@generatedData')->name('user.resident.generated');
    Route::post('/Residents/add', 'admin\UserController@create')->name('user.resident.add');
    Route::get('/Residents/show/{id?}', 'admin\UserController@show')->name('user.resident.show');
    Route::post('/Residents/edit', 'admin\UserController@showEditForm')->name('user.resident.edit');
    Route::put('/Residents/update', 'admin\UserController@updateUser')->name('user.resident.update');
    Route::post('/Residents/delete', 'admin\UserController@deleteUser')->name('user.resident.delete');
    Route::post('/Resident/FilteredIndex' , 'admin\UserController@GetFiltered')->name('user.resident.GetFiltered');

    Route::get('businesspermits', 'ApplicationController@businessPermits');

    Route::post('/Admin/list' , 'UserController@GetFilteredAdminlist')->name('adminlist.GetFiltered');


    // Applications
    Route::get('/applications', 'ApplicationController@applications')->name('admin.apply');
    Route::get('/pending-applications', 'ApplicationController@pending_applications')->name('admin.pending');
    Route::get('/view-application/{id}', 'ApplicationController@view_application')->name('admin.view_application');
    Route::post('/applications/verify', 'ApplicationController@verifyApplication')->name('admin.verify_application');
    Route::post('/applications/change_status', 'ApplicationController@changeStatus')->name('admin.change_status');
    Route::post('/applications/search', 'ApplicationController@searchApplications')->name('admin.applications.search');
    Route::post('/applications/delete_application', 'UserHomeController@deleteApplication')->name('admin.applications.delete_application');
    Route::get('/requirements/download/{filename}', 'ApplicationController@downloadRequirements')->name('admin.download.requirements');
    Route::post('/applications/save_notes', 'ApplicationController@saveNotes')->name('admin.applications.save_notes');



    Route::get('/transactions' , 'ApplicationController@transactions')->name('admin.transactions');
    Route::post('/transactions/complete' , 'ApplicationController@completeTransaction')->name('admin.transactions.complete');
});


// user level 1

Route::middleware('userlevel1', 'isverified','web')->prefix('/')->group(function(){
    Route::get('/home','UserHomeController@dashboard')->name('users.home');
    Route::get('/apply-permits','UserHomeController@apply')->name('users.apply');
    Route::get('/business-permit','UserHomeController@businessPermit')->name('users.businessPermit');
    Route::post('/business-permit/add','ApplicationController@createBusinessPermit')->name('users.businessPermit.add');
    
    // To Pay

    Route::get('/permits/topay', 'UserHomeController@topay')->name('users.permits.topay');
    Route::get('/payment-gateway/{applicationid?}', 'UserHomeController@payment_gateway')->name('users.permits.payment-gateway');

    Route::post('/payment-Transaction', 'UserHomeController@paymentTransaction')->name('users.paymentTransaction');

    // Application Status
    Route::get('/application-status','UserHomeController@application_status')->name('users.application_status');
    Route::get('/view-application/{id}', 'UserHomeController@view_application')->name('users.view_application');



    Route::post('/application/upload', 'UserHomeController@uploadRequirements')->name('users.application.upload');
    Route::post('/application/save_draft', 'UserHomeController@updateDraft')->name('users.application.save_draft');
    Route::post('/application/submit_application', 'UserHomeController@submitApplication')->name('users.application.submit_application');
    Route::post('/application/delete_application', 'UserHomeController@deleteApplication')->name('users.application.delete_application');
    Route::post('/application/save_notes', 'UserHomeController@saveNotes')->name('users.application.save_notes');
    Route::post('/application/history', 'UserHomeController@userApplicationHistory');


    Route::get('/user-profile','UserHomeController@UserProfile')->name('users.profile');
    Route::put('/Updateinfo','UserHomeController@create')->name('user.create.Update');
    Route::get('/verify-email','UserHomeController@verify')->name('users.verify')->withoutMiddleware(['isverified']);
    Route::post('/verify-email','UserHomeController@verified')->name('users.verify')->withoutMiddleware(['isverified']);
});



// 2 <= 7

Route::middleware('bplo','auth')->prefix('/admin')->group(function(){
    Route::get('/home', 'HomeController@index')->name('home');
    
   
    
    Route::get('/profile', 'admin\AdminController@Profile')->name('admin.profile');
    Route::put('/update', 'admin\AdminController@UpdateProfile')->name('admin.update.profile');

    Route::get('/Residents', 'admin\UserController@index')->name('user.residentlist');
    Route::get('/Residents/generated', 'admin\UserController@generatedData')->name('user.resident.generated');
    Route::post('/Residents/add', 'admin\UserController@create')->name('user.resident.add');
    Route::post('/Residents/edit', 'admin\UserController@showEditForm')->name('user.resident.edit');
    Route::put('/Residents/update', 'admin\UserController@updateUser')->name('user.resident.update');
    Route::post('/Residents/delete', 'admin\UserController@deleteUser')->name('user.resident.delete');
    Route::post('/Resident/FilteredIndex' , 'admin\UserController@GetFiltered')->name('user.resident.GetFiltered');


  


    // Applications
    Route::get('/applications', 'ApplicationController@applications')->name('admin.apply');
    Route::get('/pending-applications', 'ApplicationController@pending_applications')->name('admin.pending');
    Route::get('/view-application/{id}', 'ApplicationController@view_application')->name('admin.view_application');
    Route::post('/applications/verify', 'ApplicationController@verifyApplication')->name('admin.verify_application');
    Route::post('/applications/change_status', 'ApplicationController@changeStatus')->name('admin.change_status');
    Route::post('/applications/search', 'ApplicationController@searchApplications')->name('admin.applications.search');
    Route::post('/applications/delete_application', 'UserHomeController@deleteApplication')->name('admin.applications.delete_application');
    Route::get('/requirements/download/{filename}', 'ApplicationController@downloadRequirements')->name('admin.download.requirements');
    Route::post('/applications/save_notes', 'ApplicationController@saveNotes')->name('admin.applications.save_notes');
    Route::post('/applications/save_amount', 'ApplicationController@saveAmount')->name('admin.applications.save_amount');
});
