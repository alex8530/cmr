<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CmrController;
use App\Http\Controllers\CmrRequestController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SignPdfController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;

Route::get('/', function () {
    return view('template');
});

Route::get('/dashboard', function () {
  return  redirect('/admin/dashboard');
    // return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware([ 'auth','online'])->group(function () {

    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard')->middleware('can:dashboard.menu');
    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');

    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/password/update', [AdminController::class, 'AdminPasswordUpdate'])->name('admin.password.update');
    Route::get('/users/all', [AdminController::class, 'UsersAll'])->name('users.all')->middleware('can:users.menu');
    Route::post('/update/user/status', [AdminController::class, 'UpdateUserStatus'])->name('update.user.stauts')->middleware('can:update.user.status');



    Route::get('/cmr/create', [CmrController::class, 'create'])->name('cmr.create')->middleware('can:cmr.create');
    Route::post('/cmr/store', [CmrController::class, 'store'])->name('cmr.store');
    Route::get('/cmr/edit/{id}', [CmrController::class, 'edit'])->name('cmr.edit')->middleware('can:cmr.edit');
    Route::post('/cmr/update', [CmrController::class, 'update'])->name('cmr.update');
    Route::get('/cmr/delete/{id}', [CmrController::class, 'delete'])->name('cmr.delete')->middleware('can:cmr.delete');

    Route::get('/cmr/pending', [CmrController::class, 'PendingCmr'])->name('cmr.pending')->middleware('can:pending.cmr.menu');
    Route::get('/cmr/complete', [CmrController::class, 'CompltedCmr'])->name('cmr.complete')->middleware('can:complete.cmr.menu');
    Route::get('/cmr/details/{id}', [CmrController::class, 'DetailsCmr'])->name('cmr.details')->middleware('can:cmr.details');
    Route::get('/cmr/download/{filename}', [CmrController::class, 'DownloadCmr'])->name('cmr.download')->middleware('can:cmr.download');
    Route::get('/cmr/make/complete/{id}', [CmrController::class, 'MakeCmrComplete'])->name('cmr.make.complete');
    Route::get('/my/cmr/pending', [CmrController::class, 'MyPendingCmr'])->name('my.cmr.pending')->middleware('role:user');
    Route::get('/my/cmr/complete', [CmrController::class, 'MyCompleteCmr'])->name('my.cmr.complete')->middleware('role:user');



    Route::get('/my/requests', [CmrRequestController::class, 'MyRequest'])->name('cmr.request')->middleware('can:my.request.menu');
    Route::get('/requests/details/{id}', [CmrRequestController::class, 'RequestDetails'])->name('request.details')->middleware('can:my.request.details');
    Route::post('/requests/update/{id}', [CmrRequestController::class, 'RequestUpdate'])->name('cmr.request.update');

    Route::get('/requests/accept/{id}', [CmrRequestController::class, 'RequestAccept'])->name('request.accept')->middleware('can:pending.cmr.request.accept');
    Route::post('/requests/decline/{id}', [CmrRequestController::class, 'RequestDecline'])->name('request.decline')->middleware('can:pending.cmr.request.decline');


    Route::get('/groups/all', [GroupController::class, 'GroupAll'])->name('group.all')->middleware('can:group.menu');
    Route::get('/edit/group/{id}', [GroupController::class, 'EditGroup'])->name('edit.group')->middleware('can:group.edit');
    Route::get('/delete/group/{id}', [GroupController::class, 'DeleteGroup'])->name('delete.group')->middleware('can:group.delete');
    Route::get('/create/group/', [GroupController::class, 'CreateGroup'])->name('group.create')->middleware('can:group.add');
    Route::post('/add/group/', [GroupController::class, 'AddGroup'])->name('group.store');
    Route::post('/update/group/', [GroupController::class, 'UpdateGroup'])->name('group.update');
    Route::get('/group/cmr', [GroupController::class, 'GroupCmrs'])->name('group.cmrs')->middleware('role:user');



// Permission All Route
Route::controller(RoleController::class)->group(function(){
    Route::get('/all/permission','AllPermission')->name('all.permission')->middleware('can:all.permission.menu');
    Route::get('/add/permission','AddPermission')->name('add.permission')->middleware('can:permission.add');
    Route::post('/store/permission','StorePermission')->name('store.permission');
    Route::get('/edit/permission/{id}','EditPermission')->name('edit.permission')->middleware('can:permission.edit');
    Route::post('/update/permission','UpdatePermission')->name('update.permission');
    Route::get('/delete/permission/{id}','DeletePermission')->name('delete.permission')->middleware('can:permission.delete');


    // Route::get('/import/permission','ImportPermission')->name('import.permission');
    // Route::get('/export','Export')->name('export');
    // Route::post('/import','Import')->name('import');





});

// Role All Route
Route::controller(RoleController::class)->group(function(){
    Route::get('/all/roles','AllRoles')->name('all.roles')->middleware('can:all.role.menu');
    Route::get('/add/roles','AddRoles')->name('add.roles')->middleware('can:role.add');
    Route::post('/store/roles','StoreRoles')->name('store.roles');
    Route::get('/edit/roles/{id}','EditRoles')->name('edit.roles')->middleware('can:role.edit');
    Route::post('/update/roles','UpdateRoles')->name('update.roles');
    Route::get('/delete/roles/{id}','DeleteRoles')->name('delete.roles')->middleware('can:role.delete');


    Route::get('/add/roles/permission','AddRolesPermission')->name('add.roles.permission')->middleware('can:role.in.permission.menu');

    Route::post('/role/permission/store','RolePermissionStore')->name('role.permission.store');
    Route::get('/all/roles/permission','AllRolesPermission')->name('all.roles.permission')->middleware('can:all.role.with.permission.menu');
    Route::get('/admin/edit/roles/{id}','AdminEditRoles')->name('admin.edit.roles')->middleware('can:all.role.with.permission.edit');
    Route::post('/admin/roles/update/{id}','AdminUpdateRoles')->name('admin.roles.update');
    Route::get('/admin/delete/roles/{id}','AdminDeleteRoles')->name('admin.delete.roles')->middleware('can:all.role.with.permission.delete');


    //permission groups
    Route::get('/all/permission/group','AllPermissionGroup')->name('all.permission.group')->middleware('can:manage.role.group.menu');

    Route::get('/edit/permission/group/{id}','EditPermissionGroup')->name('edit.permission.group')->middleware('can:manage.role.group.edit');
    Route::get('/delete/permission/group/{id}','DeletePermissionGroup')->name('delete.permission.group')->middleware('can:manage.role.group.delete');
    Route::get('/create/permission/group','CreatePermissionGroup')->name('create.permission.group')->middleware('can:manage.role.group.add');
    Route::post('/store/permission/group','StorePermissionGroup')->name('store.permission.group');
    Route::post('/update/permission/group','UpdatePermissionGroup')->name('update.permission.group');


    Route::get('/import/permission','ImportPermission')->name('import.permission')->middleware('can:permission.import');
    Route::get('/export','Export')->name('export.permission')->middleware('can:permission.export');
    Route::post('/import','Import')->name('import');



});



// Admin User All Route
Route::controller(AdminController::class)->group(function(){
    Route::get('/all/admin','AllAdmin')->name('all.admin')->middleware('can:manage.admin.all.menu');
    Route::get('/add/admin','AddAdmin')->name('add.admin')->middleware('can:manage.admin.add');
    Route::post('/store/admin','StoreAdmin')->name('store.admin');
    Route::get('/edit/admin/{id}','EditAdmin')->name('edit.admin')->middleware('can:manage.admin.edit');
    Route::post('/update/admin/{id}','UpdateAdmin')->name('update.admin');
    Route::get('/delete/admin/{id}','DeleteAdmin')->name('delete.admin')->middleware('can:manage.admin.delete');

});

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login')->middleware('guest');
Route::get('/admin/register', [AdminController::class, 'AdminRegister'])->name('admin.register')->middleware('guest');
Route::post('/admin/register', [AdminController::class, 'AdminSignup'])->name('admin.signup')->middleware('guest');

// SMPT All Route
Route::controller(SettingController::class)->group(function(){
    Route::get('/smtp/setting','SmtpSetting')->name('smtp.setting')->middleware('can:setting.smtp.menu');
    Route::post('/update/smtp','SmtpUpdate')->name('update.smtp') ;


    Route::post('/mark-notification-as-read/{notification}', [CmrController::class, 'MarkAsRead']);




});

// Site Setting All Route
Route::controller(SettingController::class)->group(function(){
    Route::get('/site/setting','SiteSetting')->name('site.setting');
    Route::post('/update/site','UpdateSite')->name('update.site');


    Route::get('/testcall','testcall');


});


// sign cmr
Route::controller(SignPdfController::class)->group(function(){
    Route::get('/upload/pdf','uploadPdf')->name('upload.pdf');
    Route::post('/upload/pdf','uploadPdfPost')->name('upload.pdf.post');
    Route::post('/save/signature','saveSignature')->name('save.signature');

});



Route::get('/test', function(){

    dd( Cache::get('user-is-online' . auth()->id()));


});

Route::get('/test1', function(){

    dd( Cache::get('user-is-online' . auth()->id()));


})->middleware('online');
require __DIR__.'/auth.php';
