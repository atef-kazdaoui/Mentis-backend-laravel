<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\MenthorController;

Route::post('menthors/{menthorId}/add-category', [MenthorController::class, 'addCategoryToMenthor']);
Route::get('categories/{id}/mentors', [MenthorController::class, 'getMentorsByCategory']); // Afficher les mentors d'une catégorie
Route::post('/addcategorie', [CategorieController::class, 'addCategorie']);
Route::get('/getallcategorie', [CategorieController::class, 'getAllCategories']);
Route::delete('deletecategorie/{id}', [CategorieController::class, 'deleteCategorie']);
Route::post('/menthor/inscription', [AuthController::class, 'registerMenthor']);
Route::post('/menthorer/inscription', [AuthController::class, 'registerMenthorer']);
Route::post('/menthorer/login', [AuthController::class, 'loginMenthorer']);