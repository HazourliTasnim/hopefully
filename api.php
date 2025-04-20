<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppelOffreController;
use App\Http\Controllers\EntrepriseController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\OffreController;
use App\Http\Controllers\SoumissionController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\StatistiqueController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\AdminProfileController;

Route::get('/', function () {
    return 'API';
});


// Authentification
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'loginUser']);
Route::post('/admin/login', [AuthController::class, 'loginAdmin']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/admin/register-user', [RegisterController::class, 'register']);
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill(); // ✅ Email vérifié
        return response()->json(['message' => 'Email vérifié avec succès']);
    })->middleware(['auth:sanctum', 'signed'])->name('verification.verify');
    
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return response()->json(['message' => 'Lien de vérification envoyé.']);
    })->middleware(['auth:sanctum', 'throttle:6,1'])->name('verification.send');
    
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::post('/logout', [AuthController::class, 'logout']);

    //profile 
    Route::put('/users/{id}', [AdminController::class, 'update']); 
    Route::delete('/users/{id}', [AdminController::class, 'destroy']);

Route::middleware('auth:api')->group(function () {
    Route::get('/user', [AdminProfileController::class, 'show']);
    Route::put('/admin/update-profile', [AdminProfileController::class, 'update']);
});

// Gestion des utilisateurs
    Route::get('/users/pending', [SuperAdminController::class, 'getPendingUsers']); 
    Route::post('/admin/register', [SuperAdminController::class, 'registerAdmin']);  
    Route::get('/admin', [SuperAdminController::class, 'index']); 
    Route::post('/admin', [SuperAdminController::class, 'registerUser']); 
    Route::put('/admin/{id}', [SuperAdminController::class, 'update']); 
    Route::delete('/admin/{id}', [SuperAdminController::class, 'destroy']);
Route::get('/admin/stats', [StatistiqueController::class, 'getStats']);

    // Gestion des appels d'offre
    Route::post('/appel-offre', [AppelOffreController::class, 'store']);
});
//statestique

Route::middleware(['auth:sanctum'])->prefix('admin')->group(function () {
    //Top cards
    Route::get('/stats', [StatistiqueController::class, 'getStats']);
  //Pie chart
    Route::get('/detailed-offer-stats', [StatistiqueController::class, 'getDetailedOfferStats']);
   //Line chart
    Route::get('/offer-trend-stats', [StatistiqueController::class, 'getOfferTrendStats']);
    //side cards 
    Route::get('/offer-cards-stats', [StatistiqueController::class, 'getDashboardInfos']);
    
    
    
    // Statistiques des administrateurs : nombre d'offres créées par semaine
    Route::get('/admin-offer-stats-weekly', [StatistiqueController::class, 'getAdminOfferStatsWeekly']);

    // Statistiques des administrateurs : nombre d'offres créées par mois
    Route::get('/admin-offer-stats-monthly', [StatistiqueController::class, 'getAdminOfferStatsMonthly']);

    // Statistiques des soumissions : nombre de soumissions par offre et total général
    Route::get('/soumission-stats', [StatistiqueController::class, 'getSoumissionStats']);

    // Nombre total des offres créées par l'entreprise
    Route::get('/total-offers', [StatistiqueController::class, 'getTotalOffers']);

    // Autres statistiques recommandées (répartition par wilaya, durée moyenne, tendance mensuelle)
    Route::get('/additional-stats', [StatistiqueController::class, 'getAdditionalStats']);
});
  // Gestion des entreprises
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/entreprises', [EntrepriseController::class, 'index']);
    Route::post('/entreprises', [EntrepriseController::class, 'store']);
    Route::put('/entreprises/{id}', [EntrepriseController::class, 'update']);
    Route::delete('/entreprises/{id}', [EntrepriseController::class, 'destroy']);
});


// Affichage public des appels d'offre
Route::get('/entreprises', [EntrepriseController::class, 'index']);
Route::get('/offres', [OffreController::class, 'index']);
Route::get('/offres/{id}', [OffreController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/offres', [OffreController::class, 'store']);
    Route::put('/offres/{offre}', [OffreController::class, 'update']);
    Route::delete('/offres/{offre}', [OffreController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/favorites', [FavoriteController::class, 'index']);
    Route::post('/favorites', [FavoriteController::class, 'store']);
    Route::delete('/favorites/{id}', [FavoriteController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user/soumissions', [SoumissionController::class, 'getUserSoumission']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show']); 
    Route::put('/profile', [ProfileController::class, 'update']); 
});
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/soumissions', [SoumissionController::class, 'store']);
    Route::get('/soumissions', [SoumissionController::class, 'index']);
    Route::get('/soumissions/{id}', [SoumissionController::class, 'show']);
    Route::put('/soumissions/{id}', [SoumissionController::class, 'update']);
});

