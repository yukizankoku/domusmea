<?php

use App\Models\Property;
use App\Models\Portfolio;
use App\Models\Testimony;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PortfolioController;
use App\Http\Middleware\AdminMiddleware;

Route::get('/', function () {
    return view('landing',[
        'carousels' => Property::where('promoted', true)->where('sold', false)->where('active', true)->latest()->get(),
        'properties' => Property::where('sold', false)->where('active', true)->latest()->take(9)->get(),
        'portfolios' => Portfolio::latest()->take(9)->get(),
        'testimonies' => Testimony::latest()->get(),
    ]);
})->name('landing');

Route::get('/jual-property', function () {
    return view('services.jual-property');
});

Route::get('/renovasi', function () {
    return view('services.renovasi');
}); //DONE

Route::get('/furniture', function () {
    return view('services.furniture');
}); //DONE

Route::get('/services', function () {
    return view('services');
}); //DONE

Route::get('/join', function () {
    return view('join');
}); 

Route::get('/about', function () {
    return view('about.about');
}); //DONE

Route::get('/contact', [ContactController::class, 'showForm'])->name('contact.form'); //DONE
Route::post('/contact', [ContactController::class, 'sendEmail'])->name('contact.send'); //DONE

Route::get('/privacy-policy', function () {
    return view('others.privacy-policy');
});

Route::get('/terms-and-conditions', function () {
    return view('others.terms-and-conditions');
});

Route::get('/portfolios', [PortfolioController::class, 'index'])->name('portfolio.index');
Route::get('/portfolios/{portfolio:slug}', [PortfolioController::class, 'show'])->name('portfolio.show');

Route::get('/properties', [PropertyController::class, 'index'])->name('property.index');
Route::get('/properties/{property:code}', [PropertyController::class, 'show'])->name('property.show');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
