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



//Style/////////////////////
use App\Http\Controllers\StyleController;
Route::prefix('style')->middleware('auth')->group(function () {
    Route::get('/style', [StyleController::class, 'style'])->name('style.style'); //Processes Details
    Route::post('/styleData', [StyleController::class, 'styleDetails'])->name('style.styleData'); 
    Route::get('/styleCompare', function(){ return view('style.styleCompare'); })->name('style.styleCompare'); //Comparison
    Route::post('/compare', [StyleController::class, 'compare'])->name('style.compare');
    Route::get('analysis', [StyleController::class, 'analysis'])->name('style.analysis'); //Analysis
    Route::get('styleAnalysis', [StyleController::class, 'styleAnalysis'])->name('style.styleAnalysis');

    Route::get('line', [StyleController::class, 'line'])->name('style.line'); //Heretical Analysis
    Route::get('lineAnalysis', [StyleController::class, 'lineAnalysis'])->name('style.lineAnalysis');

    Route::get('lineSimple', [StyleController::class, 'lineSimple'])->name('style.lineSimple');  //Sequential Analysis
    Route::get('lineSimpleAnalysis', [StyleController::class, 'lineSimpleAnalysis'])->name('style.lineSimpleAnalysis');

    Route::get('multiLine', [StyleController::class, 'multiLine'])->name('style.multiLine'); //Lines Wise Heretical Analysis
    Route::get('multiLineAnalysis', [StyleController::class, 'multiLineAnalysis'])->name('style.multiLineAnalysis');

    Route::get('sequence', [StyleController::class, 'sequence'])->name('style.sequence'); //All Heretical Analysis
    Route::get('sequenceAnalysis', [StyleController::class, 'sequenceAnalysis'])->name('style.sequenceAnalysis');

    Route::post('language/{language}', [StyleController::class, 'language'])->name('style.language');

    Route::get('cache', [StyleController::class, 'cache'])->name('style.cache');

    Route::get('notification', function(){ return view('notification'); })->name('style.notification');   //Notification

});