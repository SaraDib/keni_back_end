<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CentreController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\EntrepriseController;
use App\Http\Controllers\EquipeController;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\HoraireController;
use App\Http\Controllers\OffresEmploiController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\RendezVousController;
use App\Http\Controllers\RowServiceController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TypePhotoController;
use App\Http\Controllers\ExpertController;
use App\Http\Controllers\UpdateController;
use App\Http\Controllers\AboutUsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/services/{id}/photo', [ServiceController::class, 'showPhoto']);
Route::get('/services', [ServiceController::class, 'index']);
Route::get('/services/{id}', [ServiceController::class, 'show']);
Route::get('/photos/{id}/image', [PhotoController::class, 'showPhoto']);
Route::get('/centres', [CentreController::class, 'index']);
Route::get('/equipes/{id}/image', [EquipeController::class, 'showImage']);
Route::get('/equipes', [EquipeController::class, 'index']);
Route::post('/contact-us', [ContactUsController::class, 'store']);
Route::get('/faqs', [FAQController::class, 'index']);
Route::post('/rendez-vous', [RendezVousController::class, 'store']);
Route::post('/offres-emploi', [OffresEmploiController::class, 'store']);
Route::get('/entreprises', [EntrepriseController::class, 'index']);
Route::get('/experts', [ExpertController::class, 'index']);
Route::get('/experts/{id}/image', [ExpertController::class, 'getExpertImage']);
Route::get('/experts/{id}/video', [ExpertController::class, 'getExpertVideo']);
Route::get('/updates', [UpdateController::class, 'index']);
Route::get('/updates/{id}/image', [UpdateController::class, 'showImage']);
Route::get('/about-us', [AboutUsController::class, 'index']);

// Authenticated routes
Route::middleware('auth:api')->group(function () {
    // AboutUs routes
    Route::post('/about-us', [AboutUsController::class, 'store']);
    Route::put('/about-us/{id}', [AboutUsController::class, 'update']);
    Route::delete('/about-us/{id}', [AboutUsController::class, 'destroy']);

    // Entreprise routes
    Route::get('/entreprises/{id}', [EntrepriseController::class, 'show']);
    Route::post('/entreprises', [EntrepriseController::class, 'store']);
    Route::post('/entreprises/{id}', [EntrepriseController::class, 'update']);
    Route::delete('/entreprises/{id}', [EntrepriseController::class, 'destroy']);
    Route::get('/entreprises/{id}/logo', [EntrepriseController::class, 'showLogo']);

    // User routes
    Route::get('/logout', [UserController::class, 'logout']);
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);

    // TypePhoto routes
    Route::get('/type-photos', [TypePhotoController::class, 'index']);
    Route::get('/type-photos/{id}', [TypePhotoController::class, 'show']);
    Route::post('/type-photos', [TypePhotoController::class, 'store']);
    Route::put('/type-photos/{id}', [TypePhotoController::class, 'update']);
    Route::delete('/type-photos/{id}', [TypePhotoController::class, 'destroy']);

    // Service routes
    Route::post('/services', [ServiceController::class, 'store']);
    Route::post('/services/{id}', [ServiceController::class, 'update']);
    Route::delete('/services/{id}', [ServiceController::class, 'destroy']);

    // RowService routes
    Route::get('/row-services', [RowServiceController::class, 'index']);
    Route::get('/row-services/{id}', [RowServiceController::class, 'show']);
    Route::post('/row-services', [RowServiceController::class, 'store']);
    Route::put('/row-services/{id}', [RowServiceController::class, 'update']);
    Route::delete('/row-services/{id}', [RowServiceController::class, 'destroy']);

    // Photo routes
    Route::get('/photos', [PhotoController::class, 'index']);
    Route::get('/photos/{id}', [PhotoController::class, 'show']);
    Route::post('/photos', [PhotoController::class, 'store']);
    Route::post('/photos/{id}', [PhotoController::class, 'update']);
    Route::delete('/photos/{id}', [PhotoController::class, 'destroy']);

    // ContactUs routes
    Route::get('/contact-us', [ContactUsController::class, 'index']);
    Route::get('/contact-us/{id}', [ContactUsController::class, 'show']);
    Route::put('/contact-us/{id}', [ContactUsController::class, 'update']);
    Route::delete('/contact-us/{id}', [ContactUsController::class, 'destroy']);

    // FAQ routes
    Route::get('/faqs/{id}', [FAQController::class, 'show']);
    Route::post('/faqs', [FAQController::class, 'store']);
    Route::put('/faqs/{id}', [FAQController::class, 'update']);
    Route::delete('/faqs/{id}', [FAQController::class, 'destroy']);

    // Equipe routes
    Route::get('/equipes/{id}', [EquipeController::class, 'show']);
    Route::post('/equipes', [EquipeController::class, 'store']);
    Route::post('/equipes/{id}', [EquipeController::class, 'update']);
    Route::delete('/equipes/{id}', [EquipeController::class, 'destroy']);

    // Centre routes
    Route::get('/centres/{id}', [CentreController::class, 'show']);
    Route::post('/centres', [CentreController::class, 'store']);
    Route::put('/centres/{id}', [CentreController::class, 'update']);
    Route::delete('/centres/{id}', [CentreController::class, 'destroy']);

    // Horaire routes
    Route::get('/horaires', [HoraireController::class, 'index']);
    Route::get('/horaires/{id}', [HoraireController::class, 'show']);
    Route::post('/horaires', [HoraireController::class, 'store']);
    Route::put('/horaires/{id}', [HoraireController::class, 'update']);
    Route::delete('/horaires/{id}', [HoraireController::class, 'destroy']);

    // RendezVous routes
    Route::get('/rendez-vous', [RendezVousController::class, 'index']);
    Route::get('/rendez-vous/{id}', [RendezVousController::class, 'show']);
    Route::put('/rendez-vous/{id}', [RendezVousController::class, 'update']);
    Route::delete('/rendez-vous/{id}', [RendezVousController::class, 'destroy']);

    // OffresEmploi routes
    Route::get('/offres-emploi', [OffresEmploiController::class, 'index']);
    Route::get('/offres-emploi/{id}', [OffresEmploiController::class, 'show']);
    Route::post('/offres-emploi/{id}', [OffresEmploiController::class, 'update']);
    Route::delete('/offres-emploi/{id}', [OffresEmploiController::class, 'destroy']);
    Route::get('/offres-emploi/{id}/lettre', [OffresEmploiController::class, 'showLettre']);
    Route::get('/offres-emploi/{id}/cv', [OffresEmploiController::class, 'showCV']);

    // Experts routes 
    Route::post('/experts', [ExpertController::class, 'store']);
    Route::get('/experts/{id}', [ExpertController::class, 'show']);
    Route::put('/experts/{id}', [ExpertController::class, 'update']);
    Route::delete('/experts/{id}', [ExpertController::class, 'destroy']);
    Route::post('/experts/{id}/toggle-status', [ExpertController::class, 'toggleStatus']);

    // Updates routes
    Route::post('/updates', [UpdateController::class, 'store']);
    Route::get('/updates/{id}', [UpdateController::class, 'show']);
    Route::put('/updates/{id}', [UpdateController::class, 'update']);
    Route::delete('/updates/{id}', [UpdateController::class, 'destroy']);
});