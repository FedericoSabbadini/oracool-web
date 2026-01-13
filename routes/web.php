<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\PredictionController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ControlPanelController;
use App\Http\Controllers\PredictionAddController;
use App\Http\Controllers\PredictionCloseController;
use App\Http\Controllers\PredictionEditController;
use App\Http\Controllers\LangController;
use App\Http\Controllers\OddsController;

require __DIR__.'/auth.php';
// default auth routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::get('/', [FrontController::class, 'index'])->name('home.index');
Route::post('/set-isAdmin', [FrontController::class, 'setIsAdmin'])->name('set.isAdmin');


Route::post('/set-timezone', [LangController::class, 'setTimezone'])->name('set.timezone');
Route::resource('/lang', LangController::class)
    ->only(['edit']);    
        // EDIT   /lang/{lang}/edit       -> edit    (lang.edit)   // Edit language


Route::resource('/ranking', RankingController::class)
    ->only(['index']);
    // GET    /ranking                -> index   (ranking.index)  // Show all user profiles


// Middleware for prediction status
Route::middleware(['PredictionStatus'])->group(function () {

    Route::resource('/prediction', PredictionController::class)
        ->only(['create', 'store']);
        // GET    /prediction/create      -> create  (prediction.create)  // Show create form
        // POST   /prediction             -> store   (prediction.store)   // Store new prediction


    // Middleware for authenticated users admin
    Route::middleware(['AdminMiddleware'])->group(function () {

        Route::post('/admin/odds/update', [OddsController::class, 'updateOdds'])->name('admin.odds.update');
        Route::post('/admin/matches/update', [OddsController::class, 'updateMatches'])->name('admin.matches.update');


        Route::get('/controlPanel',[ControlPanelController::class, 'index'])->name('controlPanel.index');

        Route::resource('/predictionAdd', PredictionAddController::class)
            ->only(['create','store']);
            // GET    /predictionAdd/create   -> create  (predictionAdd.create)  // Show create form
            // POST   /predictionAdd         -> store   (predictionAdd.store)   // Store new prediction
        Route::get('/predictionAdd/storeAjax', [PredictionAddController::class, 'storeAjax'])->name('predictionAdd.storeAjax');

        Route::resource('/predictionClose', PredictionCloseController::class)
            ->only(['create', 'show', 'update']);
            // GET    /predictionClose/{predictionClose}    -> show    (predictionClose.show)   // Show specific 
            // PUT   /predictionClose /{predictionClose}      -> update  (predictionClose.update)   // Update prediction

        Route::resource('/predictionEdit', PredictionEditController::class)
            ->only(['create', 'show','edit']);
            // GET    /predictionEdit/{predictionEdit}    -> show    (predictionEdit.show)   // Show specific 
            // GET   /predictionEdit/{predictionEdit}/edit       -> edit    (predictionEdit.edit)   // Edit prediction
    });


    // Middleware for authenticated users
    Route::middleware(['UserMiddleware'])->group(function () {

        Route::resource('/userProfile', UserProfileController::class)
            ->only(['index','show']);
            // GET    /userProfile            -> index   (userProfile.index)  // Show all user profiles
            // GET    /userProfile/{userProfile}    -> show    (userProfile.show)   // Show specific user profile
    });

});