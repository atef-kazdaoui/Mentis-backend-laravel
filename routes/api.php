<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\MenthorController;
use App\Http\Middleware\CheckMenthorAccess;
use App\Http\Controllers\DisponibiliteController;
// Route pour ajouter une disponibilité
Route::post('/menthor/{menthorId}/disponibilite', [DisponibiliteController::class, 'store']);

// Route pour afficher les disponibilités d'un menthor
Route::get('/menthor/{menthorId}/disponibilites', [DisponibiliteController::class, 'index']);

// Route pour supprimer une disponibilité
Route::delete('/disponibilite/{id}', [DisponibiliteController::class, 'destroy']);

Route::post('menthors/{menthorId}/add-category', [MenthorController::class, 'addCategoryToMenthor']);

Route::post('/addcategorie', [CategorieController::class, 'addCategorie']);

Route::delete('deletecategorie/{id}', [CategorieController::class, 'deleteCategorie']);

Route::delete('/menthor/{id}', [MenthorController::class, 'destroy']);

Route::post('/menthor/inscription', [AuthController::class, 'registerMenthor']);

Route::post('/menthorer/inscription', [AuthController::class, 'registerMenthorer']);

Route::post('/menthorer/login', [AuthController::class, 'loginMenthorer']);

Route::get('categories/{id}/mentors', [MenthorController::class, 'getMentorsByCategory']); // Afficher les mentors d'une catégorie

Route::get('/getallcategorie', [CategorieController::class, 'getAllCategories']);
