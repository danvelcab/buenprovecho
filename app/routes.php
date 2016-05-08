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
Route::get('/deleteIngredient/{id_ingredient}', 'RecipeController@deleteIngredient');
//Route::get('/cookpad', 'ScrappingController@cookpad');
//Route::get('/reviseRecipes', 'ScrappingController@reviseRecipes');
//Route::get('/cookpadRecipes', 'ScrappingController@cookpadRecipes');

//Route::get('/gBI','ScrappingCanalCocinaController@getBasicIngredients');
//Route::get('/gDI','ScrappingCanalCocinaController@getDerivedIngredients');
//Route::get('/gR','ScrappingCanalCocinaController@getRecipes');

//Route::get('/gR','ScrappingRecetasFacilController@getRecipes');

//JQUERY
Route::post('/findIngredients', 'RecipeController@findIngredients');