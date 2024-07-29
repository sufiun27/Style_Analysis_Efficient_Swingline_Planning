<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthManager;

use App\Http\Controllers\UserController;


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





//LOgin routes///////////////////////////////
Route::get('/login', function () { return view('authentication.login');})->name('login');
Route::post('/authorization', [AuthManager::class, 'authentication'])->name('login.authorization');
Route::get('/logout', [AuthManager::class, 'logout'])->name('logout');


//Dashboard routes///////////////////////////
Route::get('/', function () {return view('dashboard');})->name('dashboard')->middleware('auth');
//Invoice Module Routes//////////////////////


//->middleware('authorization:emp_viewx')


//////////Employee routes/////////////////////
Route::prefix('employee')->group(function () {
    // Your employee routes go here edit
    Route::get('/register', function () { return view('employee.register');})->name('employee.register');//->middleware('authorization:emp_manage');
    Route::get('/edit/{id}', [UserController::class, 'edit'])->name('employee.edit')->middleware('authorization:emp_manage');
    Route::post('/update/{id}', [UserController::class, 'update'])->name('employee.update')->middleware('authorization:emp_manage');
    Route::get('/delete/{id}', [UserController::class, 'delete'])->name('employee.delete')->middleware('authorization:emp_manage');

    Route::post('/register/store', [UserController::class, 'store'])->name('employee.register.store');//->middleware('authorization:emp_manage');
    // Example routes:
    Route::get('/list', [UserController::class, 'list'])->name('employee.list')->middleware('authorization:emp_manage');

    Route::get('/activate/{id}', [UserController::class, 'activate'])->name('employee.activate')->middleware('authorization:emp_manage');
    Route::get('/deactivate/{id}', [UserController::class, 'deactivate'])->name('employee.deactivate')->middleware('authorization:emp_manage');
    // Add more routes as needed

    //permissions
    Route::get('/permissions/{id}', [UserController::class, 'permissions'])->name('employee.permissions')->middleware('authorization:emp_permissions');

    Route::get('/permissions/add/{e_id}/{p_id}', [UserController::class, 'addpermissions'])->name('employee.permissions.add')->middleware('authorization:emp_permissions');
    //permission remove
    Route::get('/permissions/remove/{id}', [UserController::class, 'removepermissions'])->name('employee.permissions.remove')->middleware('authorization:emp_permissions');
    //permision active
    Route::get('/permissions/activate/{id}', [UserController::class, 'activatepermissions'])->name('employee.permissions.activate')->middleware('authorization:emp_permissions');
    Route::get('/permissions/deactivate/{id}', [UserController::class, 'deactivatepermissions'])->name('employee.permissions.deactivate')->middleware('authorization:emp_permissions');
    // Add more routes as needed
});


////////////////////////////////////

Route::get('/home', function(){
    return view('home');
})->name('home');