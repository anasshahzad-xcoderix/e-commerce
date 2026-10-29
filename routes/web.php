<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;
use Illuminate\Controllers\StoreProductController;
use App\Http\Controllers\CartController;



Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/shop', [StoreController::class, 'shop'])->name('shop');
Route::get('/categories', [StoreController::class, 'categories'])->name('categories');
Route::get('/daily-sale', [StoreController::class, 'dailySale'])->name('daily-sale');
Route::get('/makers', [StoreController::class, 'makers'])->name('makers');
Route::get('/help', [StoreController::class, 'help'])->name('help');
Route::get('/contact', [StoreController::class, 'contact'])->name('contact');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/dashboard', [PageController::class, 'dashboard'])
    ->middleware('auth')
    ->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

Route::get('/analytics', [DashboardController::class, 'analytics'])
    ->middleware('auth')
    ->name('analytics');

Route::get('/whoami', function () {
    return [
        'logged_in' => \Illuminate\Support\Facades\Auth::check(),
        'user' => \Illuminate\Support\Facades\Auth::user()?->email,
        'session_id' => session()->getId(),
        'host' => request()->getHost(),
    ];
});

Route::get('/contact-form', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', CategoryController::class)->except('show');
    Route::resource('products', ProductController::class)->except('show');
});

Route::resource('categories', CategoryController::class)->except('show');
Route::get('/products', [ProductController::class, 'index'])->name('products');

Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/checkout', [CartController::class, 'placeOrder'])->name('checkout.place');