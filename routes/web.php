<?php

use App\Http\Controllers\AdministrationController;
use App\Http\Controllers\testApi;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserStockController;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [WelcomeController::class, 'index'])->name('welcome')->middleware('auth');
Route::get('/stock', [UserStockController::class, 'index'])->name('user.stock')->middleware('auth');
Route::get('/login', [LoginController::class, 'index'])->name('loginpage');
Route::post('/login', [LoginController::class, 'authenticate'])->name('authuser');
Route::post('/logout', [LoginController::class, 'logout'])->name('logoutpage');
Route::get('/pr/history', [PurchaseController::class, 'history'])->name('purchase.history')->middleware('auth');
Route::get('/pr/detail/{id}', [TransactionController::class, 'detail'])->name('transaction.detail')->middleware('auth');
Route::get('/pr/direct', [PurchaseController::class, 'direct'])->name('purchase.direct')->middleware('auth');
Route::post('/pr/direct', [PurchaseController::class, 'directadd'])->name('purchase.directadd')->middleware('auth');
Route::get('/pr/delete/{id}', [PurchaseController::class, 'delete'])->name('cart.delete')->middleware('auth');
Route::post('/pr/checkout', [PurchaseController::class, 'checkout'])->name('purchase.checkout')->middleware('auth');
Route::get('/pr/propose', [PurchaseController::class, 'propose'])->name('purchase.propose')->middleware('auth');
Route::post('/pr/propose', [PurchaseController::class, 'proposeadd'])->name('purchase.proposeadd')->middleware('auth');
Route::get('/items/{id}', [ItemsController::class, 'show'])->name('items.show')->middleware('auth');
Route::get('/cart/direct/{id}/{id_user}', [ItemsController::class, 'checkcart'])->name('items.checkcart')->middleware('auth');
Route::get('/cart/showdirectcart/{id_user}', [ItemsController::class, 'showdirectcart'])->name('items.showdirectcart')->middleware('auth');
Route::get('/cart/propose/{id}/{id_user}', [ItemsController::class, 'checkproposecart'])->name('items.checkcart')->middleware('auth');
// Route::get('/updatedetail/{id}/{newval}', [ApprovalController::class, 'getdetail'])->name('update.detail')->middleware('auth');
Route::post('/updatedetail', [ApprovalController::class, 'getdetail'])->name('update.detail')->middleware('auth');
Route::post('/updatedetailtluser', [ApprovalController::class, 'getdetailtluser'])->name('update.detailtluser')->middleware('auth');
Route::post('/updatedetailtlgam', [ApprovalController::class, 'getdetailtlgam'])->name('update.detailtlgam')->middleware('auth');


Route::get('/approval/tluser', [ApprovalController::class, 'tluser'])->name('approval.tluser')->middleware('tluser');
Route::get('/approval/tlgam', [ApprovalController::class, 'tlgam'])->name('approval.tlgam')->middleware('tlgam');
Route::get('/approval/pic', [ApprovalController::class, 'pic'])->name('approval.pic')->middleware('auth');
Route::post('/approval/pic', [ApprovalController::class, 'approvepic'])->name('approval.approvepic')->middleware('auth');
Route::post('/approval/tluser', [ApprovalController::class, 'approvetluser'])->name('approval.approvetluser')->middleware('tluser');
Route::post('/approval/tlgam', [ApprovalController::class, 'approvetlgam'])->name('approval.approvetlgam')->middleware('tlgam');
Route::post('/approval/savedata/tlgam', [ApprovalController::class, 'savedatatlgam'])->name('approval.savedatatlgam')->middleware('tlgam');
Route::post('/approval/download', [DownloadController::class, 'purchase'])->name('download.purchase')->middleware('auth');
Route::get('/approval/pic2', [ApprovalController::class, 'pic'])->name('approval.pic2');
Route::post('/approval/pic2', [ApprovalController::class, 'approvepic'])->name('approval.approvepic2');

Route::get('/approval/pending', [ApprovalController::class, 'pending'])->name('approval.pending')->middleware('auth');
Route::post('/approval/pending', [ApprovalController::class, 'approve_tl_atl'])->name('approval.approve_tl_atl')->middleware('auth');
Route::get('/approval/pending_ga', [ApprovalController::class, 'pending_ga'])->name('approval.pending_ga')->middleware('auth');
Route::post('/approval/pending_ga', [ApprovalController::class, 'approve_ga_tl'])->name('approval.approve_ga_tl')->middleware('auth');
Route::post('/approval/pending_ga/savedata-tlgam', [ApprovalController::class, 'savedata_tlgam'])->name('approval.savedata_tlgam')->middleware('auth');


Route::post('/admin/additem', [AdministrationController::class, 'additem'])->name('admin.additem')->middleware('auth');
Route::post('/admin/item', [AdministrationController::class, 'saveitem'])->name('admin.saveitem')->middleware('auth');
Route::get('/admin/item/{id}', [AdministrationController::class, 'show'])->name('admin.itemshow')->middleware('auth');
Route::get('/admin/direct', [AdministrationController::class, 'admindirect'])->name('admin.direct')->middleware('auth');
Route::get('/admin/direct/export', [AdministrationController::class, 'export'])->name('admin.direct.export')->middleware('auth');
Route::get('/admin/pr', [AdministrationController::class, 'adminpr'])->name('admin.pr')->middleware('auth');
Route::get('/admin/masteritem', [AdministrationController::class, 'masteritem'])->name('admin.masteritem')->middleware('auth');
Route::post('/admin/pr', [AdministrationController::class, 'postreceipt'])->name('admin.postreceipt')->middleware('auth');
Route::get('/admin/user', [AdministrationController::class, 'user'])->name('admin.user')->middleware('auth');
Route::get('/admin/user/add', [AdministrationController::class, 'useradd'])->name('admin.useradd')->middleware('auth');
Route::post('/admin/user/add', [AdministrationController::class, 'usersearch'])->name('admin.usersearch')->middleware('auth');
Route::get('/admin/user/{id}', [AdministrationController::class, 'usershow'])->name('admin.usershow')->middleware('auth');
Route::post('/admin/user/saveuser', [AdministrationController::class, 'saveuser'])->name('admin.saveuser')->middleware('auth');
// Route::post('/admin/user/adduser', [AdministrationController::class, 'useradddb'])->name('admin.storeuser')->middleware('auth');
Route::post('/admin/user/storeuser', [AdministrationController::class, 'storeuser'])->name('admin.storeuser')->middleware('auth');

Route::get('/testapi/{idemp}', [testApi::class, 'aaaa']);
Route::get('/register', [RegisterController::class, 'register'])->name('register.index');
Route::post('/register', [RegisterController::class, 'employee'])->name('register.search');
Route::post('/register/store', [RegisterController::class, 'store'])->name('register.store');


Route::get('/notif', [NotificationController::class, 'notification'])->name('test.notif');

Route::get('redirlog', function () {
    return redirect('/login')->with('nosession', 'Invalid Session');
})->name("redirlog");

Route::get('/sso', [LoginController::class, 'checksso'])->name('sso.check');
Route::get('/employee', [LoginController::class, 'employee'])->name('employee.check');

Route::get('/testauth', [testApi::class, 'testauth']);
