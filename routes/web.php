<?php
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\BookController;

Route::get('/', function () {
    return view('home');
});


Route::get('/shop', [StoreController::class, 'shop'])->name('shop');
Route::get('/categories', [StoreController::class, 'categories'])->name('categories');
Route::get('/daily-sale', [StoreController::class, 'dailySale'])->name('daily-sale');
Route::get('/makers', [StoreController::class, 'makers'])->name('makers');
Route::get('/help', [StoreController::class, 'help'])->name('help');
Route::get('/contact', [StoreController::class, 'contact'])->name('contact');




Route::get('/login', [SocialAuthController::class, 'showLogin'])->name('login');
Route::post('/logout', [SocialAuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [PageController::class, 'dashboard'])
    ->middleware('auth')
    ->name('dashboard');



Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');





Route::get('/analytics', [DashboardController::class, 'analytics'])
    ->middleware('auth')
    ->name('analytics');


    Route::get('/whoami', function () {
    return [
        'logged_in'  => \Illuminate\Support\Facades\Auth::check(),
        'user'       => \Illuminate\Support\Facades\Auth::user()?->email,
        'session_id' => session()->getId(),
        'host'       => request()->getHost(),
    ];

    Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');
});


    
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', CategoryController::class)->except('show');
    Route::resource('products', ProductController::class)->except('show');
    Route::resource('books', BookController::class)->except('show');
});

Route::resource('categories', CategoryController::class)->except('show');
Route::get('/', [HomeController::class, 'index'])->name('home');
