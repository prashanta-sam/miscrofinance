<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\RecurringDipositeController;

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


// Route for the sign-in page
Route::get('/home',function(){
    return View('dashboard');
});
Route::get('/', [UserController::class,'login'])->name('login');
Route::post('/auth', [UserController::class,'authenticate'])->name('auth');
// Route::post('/store', [UserController::class,   'store']);

//Route::post('/user/show', [UserController::class,'show'])->name('list_user');


Route::middleware('api')->group(function () {
    // Define your API routes here
    // Route::get('/api/show', function(){
    //     return 123;
    // });
    //Route::get('/api/show', [UserController::class,   'show'])->name('list_user');
});


// Routes for authenticated users
Route::middleware(['checkSession'])->group(function () {
    // Dashboard route for ALL
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/setings', [DashboardController::class, 'updateSettings'])->name('settings');
    //================== customer
    Route::get('/customer/list', [CustomerController::class, 'show'])->name('list_customer');
    Route::get('/customer/add', [CustomerController::class,'add'])->name('add_customer');
    Route::post('/customer/store', [CustomerController::class, 'store'])->name('store_customer');
    Route::get('/customer/{user}/edit', [CustomerController::class,'edit'])->name('edit_customer');
    Route::put('/customer/update', [CustomerController::class,'update'])->name('update_customer');
    Route::get('/customer/delete/{user}', [CustomerController::class, 'destroy'])->name('delete_customer');
    Route::put('/customer/status/{id}', [CustomerController::class, 'statusUpdate'])->name('update_customer_status');


 //================== users  ex: stuff,admin any other users
    Route::get('/user/list', [UserController::class,'show'])->name('list_user');
    Route::get('/user/add', [UserController::class,'add'])->name('add_user');
    Route::post('/user/store', [UserController::class, 'store'])->name('store_user');
    Route::get('/users/{user}/edit', [UserController::class,'edit'])->name('edit_user');
    Route::put('/user/update', [UserController::class,'update'])->name('update_user');
    Route::get('/user/delete/{user}', [UserController::class, 'destroy'])->name('delete_user');


    Route::put('/user/status/{id}', [UserController::class, 'statusUpdate'])->name('update_user_status');


    //================== EMIs
    Route::get('/emi/{emi}/list', [LoanController::class,'showEmi'])->name('show_emi');
    Route::put('/emi/update/{id}', [LoanController::class,'updateEmi'])->name('update_emi');


    //================== loan
    Route::get('/loan/list', [LoanController::class,'show'])->name('list_loan');
    Route::get('/loan/list/{customer_id}', [LoanController::class,'showByCust'])->name('list_loan_customer');
    Route::get('/loan/add/{user}', [LoanController::class,'add'])->name('add_loan');
    Route::post('/loan/store', [LoanController::class, 'store'])->name('store_loan');
    Route::get('/loans/{loan}/edit', [LoanController::class,'edit'])->name('edit_loan');
    Route::put('/loan/update', [LoanController::class,'update'])->name('update_loan');
    Route::get('/loan/delete/{loan}', [LoanController::class, 'destroy'])->name('delete_loan');

    //============= Daily collection

    Route::get('/collection/daily/list', [RecurringDipositeController::class,'show'])->name('list_rd');
    Route::get('/collection/daily/add/{customer_id}', [RecurringDipositeController::class,'add'])->name('add_rd');
    Route::post('/collection/daily/store', [RecurringDipositeController::class,'store'])->name('store_rd');
    Route::get('/collection/daily/list/{customer_id}', [RecurringDipositeController::class,'showByCust'])->name('list_rd_customer');
    Route::get('/collection/daily/emi/{emi}/list', [RecurringDipositeController::class,'showEmi'])->name('show_rd_emi');
    Route::put('/collection/daily/emi/update/{id}', [RecurringDipositeController::class,'updateEmi'])->name('update_rd_emi');



    Route::get('/loan/logout',function(){

            Auth::logout();
            return redirect()->route('login'); // Redirect to login page after logout

    })->name('logout_user');

    // Other authenticated user routes...
});


//    Route::get('/user/store',function(){

//     return 'hello';
//    });
