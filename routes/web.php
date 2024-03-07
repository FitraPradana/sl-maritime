<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BrokerController;
use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\InsurancePaymentController;
use App\Http\Controllers\LoginController as ControllersLoginController;
use App\Http\Controllers\LoginCpanelController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\MSTInsuranceBrokerController;
use App\Http\Controllers\MSTInsuranceInsurerController;
use App\Http\Controllers\MSTInsuranceTypeController;
use App\Http\Controllers\MSTNavCompanyController;
use App\Http\Controllers\PermissionCpanelController;
use App\Http\Controllers\PhishingController;
use App\Http\Controllers\PhyshingController;
use App\Http\Controllers\RoleCpanelController;
use App\Http\Controllers\RoleHasPermissionCpanelController;
use App\Http\Controllers\TESTController;
use App\Http\Controllers\TicketingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserHasPermissionCpanelController;
use App\Http\Controllers\UserHasRolesCpanelController;
use App\Imports\MSTNavCompanyImport;
use App\Models\MSTInsuranceBroker;
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
    return redirect('/Home');
});

// Route::match(['get', 'post'], '/', [PhishingController::class, 'index'])->name('phising.index');


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
Route::match(['get', 'post'], 'Roles', [RoleCpanelController::class, 'index'])->name('roles.index')->middleware('auth');
Route::match(['get', 'post'], 'Roles/Store', [RoleCpanelController::class, 'store'])->name('roles.store')->middleware('auth');
Route::delete('Roles/delete/{id}', [RoleCpanelController::class, 'delete'])->name('roles.delete')->middleware('auth');
// MST Role has Permission
Route::match(['get', 'post'], 'RoleHasPermission', [RoleHasPermissionCpanelController::class, 'index'])->name('role_has_permission.index')->middleware('auth');
Route::match(['get', 'post'], 'RoleHasPermission/Store', [RoleHasPermissionCpanelController::class, 'store'])->name('role_has_permission.store')->middleware('auth');
// MST Permission
Route::match(['get', 'post'], 'Permissions', [PermissionCpanelController::class, 'index'])->name('permissions.index')->middleware('auth');
Route::match(['get', 'post'], 'Permissions/Store', [PermissionCpanelController::class, 'store'])->name('permissions.store')->middleware('auth');


// MST USER
Route::match(['get', 'post'], 'Users', [UserController::class, 'index'])->name('users.index')->middleware('auth');
Route::match(['get', 'post'], 'user/store', [UserController::class, 'store'])->name('user.store')->middleware('auth');
Route::match(['get', 'put'], 'User/ChangePassword/{id}', [UserController::class, 'changePassword'])->name('user.change_password')->middleware('auth');
// User has Role
Route::match(['get', 'post'], 'UserHasRoles', [UserHasRolesCpanelController::class, 'index'])->name('user_has_roles.index')->middleware('auth');
Route::match(['get', 'post'], 'UserHasRoles/Store', [UserHasRolesCpanelController::class, 'store'])->name('user_has_roles.store')->middleware('auth');
// User has Permission
Route::match(['get', 'post'], 'UserHasPermission', [UserHasPermissionCpanelController::class, 'index'])->name('user_has_permission.index')->middleware('auth');

// MST Employee
Route::get('/employee', [App\Http\Controllers\EmployeeController::class, 'index'])->middleware('auth');
Route::get('/employee/json', [App\Http\Controllers\EmployeeController::class, 'json'])->name('employee.json')->middleware('auth');

// MST BROKER INSURANCE
Route::get('/Insurance/Broker', [App\Http\Controllers\MSTInsuranceBrokerController::class, 'index'])->middleware('auth');
Route::get('/Insurance/Broker/json', [App\Http\Controllers\MSTInsuranceBrokerController::class, 'json'])->name('broker.json')->middleware('auth');
Route::match(['get', 'post'], 'Insurance/Broker/store', [MSTInsuranceBrokerController::class, 'store'])->name('broker.store')->middleware('auth');
Route::match(['get', 'put'], 'Insurance/Broker/update/{id}', [MSTInsuranceBrokerController::class, 'update'])->name('broker.update')->middleware('auth');
Route::delete('Insurance/Broker/delete/{id}', [MSTInsuranceBrokerController::class, 'delete'])->name('broker.delete')->middleware('auth');
Route::match(['get', 'post'], '/broker_import', [MSTInsuranceBrokerController::class, 'import'])->name('broker.import')->middleware('auth');

// MST TYPE INSURANCE
Route::get('/Insurance/Type', [App\Http\Controllers\MSTInsuranceTypeController::class, 'index'])->middleware('auth');
Route::get('/Insurance/Type/json', [App\Http\Controllers\MSTInsuranceTypeController::class, 'json'])->name('insurance_type_json')->middleware('auth');
Route::match(['get', 'post'], 'Insurance/Type/store', [MSTInsuranceTypeController::class, 'store'])->name('insurance_type.store')->middleware('auth');
Route::match(['get', 'put'], 'Insurance/Type/update/{id}', [MSTInsuranceTypeController::class, 'update'])->name('insurance_type.update')->middleware('auth');
Route::delete('Insurance/Type/delete/{id}', [MSTInsuranceTypeController::class, 'delete'])->name('insurance_type.delete')->middleware('auth');
Route::match(['get', 'post'], '/insurance_type_import', [MSTInsuranceTypeController::class, 'import'])->name('insurance_type_import')->middleware('auth');

// MST INSURER INSURANCE
Route::get('/Insurance/Insurer', [App\Http\Controllers\MSTInsuranceInsurerController::class, 'index'])->middleware('auth');
Route::get('/Insurance/Insurer/json', [App\Http\Controllers\MSTInsuranceInsurerController::class, 'json'])->name('insurer.json')->middleware('auth');
Route::match(['get', 'post'], 'Insurance/Insurer/store', [MSTInsuranceInsurerController::class, 'store'])->name('insurer.store')->middleware('auth');
Route::match(['get', 'put'], 'Insurance/Insurer/update/{id}', [MSTInsuranceInsurerController::class, 'update'])->name('insurer.update')->middleware('auth');
Route::delete('Insurance/Insurer/delete/{id}', [MSTInsuranceInsurerController::class, 'delete'])->name('insurer.delete')->middleware('auth');
Route::match(['get', 'post'], '/insurance_insurer_import', [MSTInsuranceInsurerController::class, 'import'])->name('insurance_insurer_import')->middleware('auth');

// MST NAV COMPANY
Route::get('/NavCompany', [App\Http\Controllers\MSTNavCompanyController::class, 'index'])->middleware('auth');
Route::get('/NavCompany/json', [App\Http\Controllers\MSTNavCompanyController::class, 'json'])->name('navcompany.json')->middleware('auth');
Route::match(['get', 'post'], 'NavCompany/store', [MSTNavCompanyController::class, 'store'])->name('navcompany.store')->middleware('auth');
Route::match(['get', 'put'], 'NavCompany/update/{id}', [MSTNavCompanyController::class, 'update'])->name('navcompany.update')->middleware('auth');
Route::delete('NavCompany/delete/{id}', [MSTNavCompanyController::class, 'delete'])->name('navcompany.delete')->middleware('auth');
Route::match(['get', 'post'], '/nav_company_import', [MSTNavCompanyController::class, 'import'])->name('nav_company_import')->middleware('auth');

// MST TICKETING IT
Route::match(['get', 'post'], '/Ticketing', [TicketingController::class, 'index'])->name('ticketing.index')->middleware('auth');

// MST INSURANCE
Route::match(['get', 'post'], '/Insurance/RenewalMonitoring', [InsuranceController::class, 'index'])->name('insurance.renewal_monitoring')->middleware('auth');
Route::get('/insurance/form_add_renewal', [App\Http\Controllers\InsuranceController::class, 'form_add_renewal'])->name('insurance.form_add_renewal')->middleware('auth');
Route::match(['get', 'post'], 'insurance/renewal_monitoring/store', [InsuranceController::class, 'store'])->name('insurance.store')->middleware('auth');
Route::post('/insurance/renewal_monitoring/saveBroker', [App\Http\Controllers\InsuranceController::class, 'saveBroker'])->name('insurance.saveBroker')->middleware('auth');
Route::match(['get', 'post'], 'insurance/get_renewal', [InsuranceController::class, 'get_renewal'])->name('insurance.get_renewal')->middleware('auth');
Route::match(['get', 'post'], 'insurance/testing', [InsuranceController::class, 'testing'])->name('insurance.testing')->middleware('auth');
Route::match(['get', 'post'], '/Insurance/UpdateRenewal/{id}', [InsuranceController::class, 'form_update_renewal'])->name('insurance.form_update_renewal')->middleware('auth');
Route::match(['get', 'put'], 'Insurance/renewal_monitoring/update_need_action/{id}', [InsuranceController::class, 'update_need_action'])->name('insurance.update_need_action')->middleware('auth');
// EDIT
Route::match(['get', 'post'], '/Insurance/Edit/{id}', [InsuranceController::class, 'edit'])->name('insurance.edit')->middleware('auth');
Route::match(['get', 'put'], '/Insurance/Update', [InsuranceController::class, 'update'])->name('insurance.update')->middleware('auth');
// NEED ACTION
Route::match(['get', 'post'], '/Insurance/UpdateNeedAction/{id}', [InsuranceController::class, 'form_need_action'])->name('insurance.form_need_action')->middleware('auth');
Route::match(['get', 'put'], '/Insurance/NeedAction/Save', [InsuranceController::class, 'save_needAction'])->name('insurance.save_needAction')->middleware('auth');



Route::match(['get', 'post'], '/Insurance/EditInsurance', [InsuranceController::class, 'form_update_needAction'])->name('insurance.form_update_needAction')->middleware('auth');
Route::match(['get', 'put'], '/Insurance/EditInsurance/Save', [InsuranceController::class, 'save_needAction'])->name('insurance.save_needAction')->middleware('auth');

// Insurance Payment Monitoring
Route::match(['get', 'post'], 'Insurance/PaymentMonitoring', [InsurancePaymentController::class, 'index'])->name('insurance_payment_monitoring.index')->middleware('auth');
Route::match(['get', 'put'], 'insurance/payment_monitoring/update_payment_date/{id}', [InsurancePaymentController::class, 'update_payment_date'])->name('insurance_payment.update_payment_date')->middleware('auth');

// MST CREWING
Route::get('/crewing/report', [App\Http\Controllers\CrewingController::class, 'crewing_report'])->name('crewing_report')->middleware('auth');
Route::get('/crewing/report/json', [App\Http\Controllers\CrewingController::class, 'crewing_report_json'])->name('crewing_report_json')->middleware('auth');

Route::get('/recaptcha', [App\Http\Controllers\LoginCpanelController::class, 'recaptcha'])->name('recaptcha');




// Route::get('/konek_sql', [App\Http\Controllers\LoginCpanelController::class, 'konek_sql'])->name('konek_sql');

Route::get('send-mail', [MailController::class, 'index']);
Route::get('getRenewalInsurance-mail', [MailController::class, 'actionGetRenewalInsurance']);




Route::match(['get', 'post'], '/PhisingTarget', [PhishingController::class, 'phisingtarget'])->name('phisingtarget.data');
Route::match(['get', 'post'], '/PhisingTarget/Save', [PhishingController::class, 'phisingtarget_save'])->name('phisingtarget.phisingtarget_save');
Route::delete('PhisingTarget/delete/{id}', [PhishingController::class, 'phisingtarget_delete'])->name('phisingtarget.delete')->middleware('auth');
Route::match(['get', 'post'], '/PhisingTarget/Mail/{id}', [PhishingController::class, 'phisingtarget_mail'])->name('phisingtarget.mail');

// PhisingDetected
Route::match(['get', 'post'], '/PhisingDetected', [PhishingController::class, 'phisingdetected'])->name('phisingdetected.data');
Route::match(['get', 'post'], '/PhisingDetected/Save', [PhishingController::class, 'phisingdetected_save'])->name('phisingdetected.phisingdetected_save');
Route::delete('PhisingDetected/delete/{id}', [PhishingController::class, 'phisingdetected_delete'])->name('phisingdetected.delete')->middleware('auth');




Route::match(['get', 'post'], '/PhisingTarget/Mail/SendMail', [PhishingController::class, 'phisingtarget_sendmail_all'])->name('phisingtarget_sendmail_all');
Route::match(['get', 'post'], '/AlertDetected', [PhishingController::class, 'redirect_detected'])->name('phising.redirect_detected');



Route::match(['get', 'post'], '/Coba', [TESTController::class, 'coba'])->name('coba');
Route::match(['get', 'post'], '/Coba_SendMail', [TESTController::class, 'coba_send_email'])->name('coba_send_email');
Route::match(['get', 'post'], '/cekDataNotifInsuranceH_60', [TESTController::class, 'cekDataNotifInsuranceH_60'])->name('cekDataNotifInsuranceH_60');
Route::match(['get', 'post'], '/cekDataNotifInsuranceH_30', [TESTController::class, 'cekDataNotifInsuranceH_30'])->name('cekDataNotifInsuranceH_30');
Route::match(['get', 'post'], '/cekDataNotifInsuranceH_10', [TESTController::class, 'cekDataNotifInsuranceH_10'])->name('cekDataNotifInsuranceH_10');
Route::match(['get', 'post'], '/cekDataNotifInsurancePaymentH_30', [TESTController::class, 'cekDataNotifInsurancePaymentH_30'])->name('cekDataNotifInsurancePaymentH_30');
Route::match(['get', 'post'], '/cekDataNotifInsurancePaymentH_15', [TESTController::class, 'cekDataNotifInsurancePaymentH_15'])->name('cekDataNotifInsurancePaymentH_15');
Route::match(['get', 'post'], '/cekDataNotifInsurancePaymentH_7', [TESTController::class, 'cekDataNotifInsurancePaymentH_7'])->name('cekDataNotifInsurancePaymentH_7');
Route::match(['get', 'post'], '/InsertNeedAction', [TESTController::class, 'InsertNeedAction'])->name('InsertNeedAction');
Route::match(['get', 'post'], '/UpdateExpired', [TESTController::class, 'UpdateExpired'])->name('UpdateExpired');
Route::match(['get', 'post'], '/UpdateNotActive', [TESTController::class, 'UpdateNotActive'])->name('UpdateNotActive');
