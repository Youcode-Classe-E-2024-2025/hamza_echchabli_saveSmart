<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\GoalController;


Route::get('/', [HomeController::class, 'index']);



// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);


// Registration Routes
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/{id}', [DashController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/transactions', [DashController::class, 'transactions'])->name('dashboard.transactions');
    Route::get('/dashboard/members', [DashController::class, 'members'])->name('dashboard.members');
    Route::get('/dashboard/charts', [DashController::class, 'charts'])->name('dashboard.charts');
});



Route::middleware(['auth'])->group(function () {
    Route::get('/profiles', [ProfileController::class, 'index']);
    Route::post('/profiles', [ProfileController::class, 'store'])->name('profiles.store');
    // Route::post('/profiles/login', [ProfileController::class, 'login'])->name('profiles.login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/manage/activate/{id}', [DashController::class, 'activate'])->name('profiles.activate');
    Route::get('/manage/deactivate/{id}', [DashController::class, 'deactivate'])->name('profiles.deactivate');
    Route::get('/manage/archive/{id}', [DashController::class, 'archive'])->name('profiles.archive');
});


Route::get('/dashboard/{id}/edit', [DashController::class, 'edit'])->name('transactions.edit');

Route::post('/dashboard/update', [DashController::class, 'update'])->name('dashboard.update');

Route::get('/stat', [DashController::class, 'stat']);




Route::post('/dashboard/category', [DashController::class, 'storeCategory'])->name('categories.store');

Route::post('/dashboard/Transaction', [DashController::class, 'storeTransaction'])->name('Transaction.store');


Route::get('/manage', [DashController::class, 'manage'])->name('profiles.manage');

Route::post('/dashboard/category/delete/{id}', [DashController::class, 'DeleteCategory']);




Route::get('/typescategorie/{type}', [DashController::class, 'returnCategories']);


// Route::get('/get-categories', function(Request $request) {
//     $type = $request->type;

//     // Filter categories based on type (expense or revenue)
//     $categories = Categorie::where('type_id', $type == 'expense' ? 2 : 1)->get();

//     return response()->json(['categories' => $categories]);
// });

    Route::get('/goals', [DashController::class, 'Goals'])->name('goals.Goals');
    Route::post('/goals', [DashController::class, 'store'])->name('goals.store');

    Route::post('/submitGoal', [DashController::class, 'submitGoal'])->name('goals.store');







