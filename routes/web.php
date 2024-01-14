<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BrokerController;
use App\Http\Controllers\LoginController as ControllersLoginController;
use App\Http\Controllers\LoginCpanelController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // return view('/welcome');
    return redirect('Cpanel/Login');
});

Auth::routes();


// Login
Route::get('/Cpanel/Login', [App\Http\Controllers\LoginCpanelController::class, 'cpanel_login'])->name('cpanel_login')->middleware('guest');
Route::match(['get', 'post'], '/cpanel_login_proses', [LoginCpanelController::class, 'cpanel_login_proses'])->name('cpanel_login_proses');

// Logout
Route::get('/Cpanel/Logout', [App\Http\Controllers\LoginCpanelController::class, 'logout'])->name('cpanel_logout');

// Home
Route::get('/Home', [App\Http\Controllers\HomeController::class, 'index'])->name('home.index')->middleware('auth');
Route::get('/home/employee', [App\Http\Controllers\HomeController::class, 'home_employee'])->name('home.employee');

// MST Role
Route::get('/role', [App\Http\Controllers\RoleCpanelController::class, 'index'])->name('role.index')->middleware('auth');
Route::get('/role/json', [App\Http\Controllers\RoleCpanelController::class, 'json'])->name('role.json')->middleware('auth');
Route::get('/roleHasPermission', [App\Http\Controllers\RoleCpanelController::class, 'role_has_permission'])->name('role_has_permission')->middleware('auth');
Route::get('/roleHasPermission/json', [App\Http\Controllers\RoleCpanelController::class, 'role_has_permission_json'])->name('role_has_permission_json')->middleware('auth');

// MST Permission
Route::get('/permission', [App\Http\Controllers\PermissionCpanelController::class, 'index'])->name('permission.index')->middleware('auth');
Route::get('/permission/json', [App\Http\Controllers\PermissionCpanelController::class, 'json'])->name('permission.json')->middleware('auth');


// MST USER
Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('user.index')->middleware('auth');
Route::match(['get', 'post'], 'user/json', [UserController::class, 'json'])->name('user.json')->middleware('auth');
Route::match(['get', 'post'], 'user/store', [UserController::class, 'store'])->name('user.store')->middleware('auth');
Route::match(['get', 'put'], 'User/ChangePassword/{id}', [UserController::class, 'changePassword'])->name('user.change_password')->middleware('auth');
Route::get('/userHasRoles', [App\Http\Controllers\UserController::class, 'user_has_roles'])->name('user_has_roles')->middleware('auth');
Route::get('/userHasRoles/json', [App\Http\Controllers\UserController::class, 'user_has_roles_json'])->name('user_has_roles')->middleware('auth');

// MST Employee
Route::get('/employee', [App\Http\Controllers\EmployeeController::class, 'index'])->middleware('auth');
Route::get('/employee/json', [App\Http\Controllers\EmployeeController::class, 'json'])->name('employee.json')->middleware('auth');

// MST BROKER INSURANCE
Route::match(['get', 'post'], 'broker/store', [BrokerController::class, 'store'])->name('broker.store')->middleware('auth');

// MST TICKETING IT
Route::get('/ticketing', [App\Http\Controllers\TicketingController::class, 'index'])->name('ticketing.index')->middleware('auth');
Route::get('/ticketing/json', [App\Http\Controllers\TicketingController::class, 'json'])->name('ticketing.index')->middleware('auth');

// MST INSURANCE
Route::get('/insurance/renewal_monitoring', [App\Http\Controllers\InsuranceController::class, 'index'])->name('insurance_renewal_monitoring.index')->middleware('auth');
Route::get('/insurance/renewal_monitoring/json', [App\Http\Controllers\InsuranceController::class, 'json'])->name('insurance.json')->middleware('auth');
Route::get('/insurance/form_add_renewal', [App\Http\Controllers\InsuranceController::class, 'form_add_renewal'])->name('insurance.form_add_renewal')->middleware('auth');
Route::post('/insurance/renewal_monitoring/store', [App\Http\Controllers\InsuranceController::class, 'store'])->name('insurance.store')->middleware('auth');
Route::post('/insurance/renewal_monitoring/saveBroker', [App\Http\Controllers\InsuranceController::class, 'saveBroker'])->name('insurance.saveBroker')->middleware('auth');

Route::get('/insurance/payment_monitoring', [App\Http\Controllers\InsurancePaymentController::class, 'index'])->name('insurance_payment_monitoring.index')->middleware('auth');
Route::get('/insurance/payment_monitoring/json', [App\Http\Controllers\InsurancePaymentController::class, 'json'])->name('insurance_payment_monitoring.json')->middleware('auth');

// MST CREWING
Route::get('/crewing/report', [App\Http\Controllers\CrewingController::class, 'crewing_report'])->name('crewing_report')->middleware('auth');
Route::get('/crewing/report/json', [App\Http\Controllers\CrewingController::class, 'crewing_report_json'])->name('crewing_report_json')->middleware('auth');




