<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'HomeController@showWelcome');

Route::post('/findRecipes', 'RecipeController@findRecipes');
Route::post('/findRecipesWithSuggestions', 'RecipeController@findRecipesWithSuggestions');
Route::get('/findAllRecipes', 'RecipeController@findAllRecipes');
Route::get('/editRecipe/{id}', 'RecipeController@editRecipe');
Route::post('/updateRecipe', 'RecipeController@updateRecipe');
Route::get('/createRecipe', 'RecipeController@createRecipe');
Route::post('/saveRecipe', 'RecipeController@saveRecipe');
Route::get('/deleteIngredient/{id_ingredient}', 'RecipeController@deleteIngredient');
Route::post('/findSecondary', 'RecipeController@findSecondaryIngredients');
Route::post('/countRecipes', 'RecipeController@countRecipes');

//JQUERY
Route::post('/findIngredients', 'RecipeController@findIngredients');