<?php

use App\Http\Controllers\LivreController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NouveautesController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Middleware\AdminMiddleware;


Auth::routes();

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/livres', [LivreController::class, 'index'])->name('livres.index');
    Route::get('/livres/create', [LivreController::class, 'create'])->name('livres.create');
    Route::post('/livres', [LivreController::class, 'store'])->name('livres.store');
    Route::get('/livres/{id}', [LivreController::class, 'show'])->name('livres.show');
    Route::delete('/livres/{id}', [LivreController::class, 'destroy'])->name('livres.destroy');
    Route::get('/recherche', [LivreController::class, 'search'])->name('livres.search');

    Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
    Route::get('/nouveautes', [NouveautesController::class, 'index'])->name('nouveautes.index');
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/payment/form', [PaymentController::class, 'showPaymentForm'])->name('payment.form');
    Route::post('/payment/pay', [PaymentController::class, 'pay'])->name('payment.pay');
    Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/error', [PaymentController::class, 'error'])->name('payment.error');
    
    
    
    Route::get('/stripe/form', [StripePaymentController::class, 'showForm'])->name('stripe.form');
    Route::post('/payment/stripe/pay', [StripePaymentController::class, 'pay'])->name('stripe.pay');

    Route::middleware(['auth', 'admin'])->group(function () {
        // Routes réservées aux administrateurs
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    });


    Route::middleware(['auth', AdminMiddleware::class])->group(function () {
        Route::get('/livres/{livre}/edit', [LivreController::class, 'edit'])->name('livres.edit');
        Route::put('/livres/{livre}', [LivreController::class, 'update'])->name('livres.update');
    });

    Route::delete('/messages/{message}', [MessageController::class, 'destroy'])
    ->name('messages.destroy')
    ->middleware(AdminMiddleware::class);


    Route::get('/payment/success', function () {
        return view('payment_success');
    })->name('payment.success');
    
    Route::get('/payment/error', function () {
        return view('payment_error');
    })->name('payment.error');


    Route::post('/panier/ajouter/{livre}', [App\Http\Controllers\PanierController::class, 'ajouter'])->name('panier.ajouter');
    Route::get('/panier', [App\Http\Controllers\PanierController::class, 'index'])->name('panier.index');
    Route::delete('/panier/{panier}', [App\Http\Controllers\PanierController::class, 'supprimer'])->name('panier.supprimer');

    
    Route::get('/paiement', [App\Http\Controllers\PaymentController::class, 'index'])->name('paiement.index');


    Route::get('/paiement/historique', [PaymentController::class, 'historique'])
    ->name('paiement.historique')
    ->middleware(AdminMiddleware::class);
    

});