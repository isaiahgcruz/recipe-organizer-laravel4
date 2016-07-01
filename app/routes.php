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

Route::get('/', function()
{
	return Redirect::to('home');
});


Route::get('/login', ['uses' => 'HomeController@showLoginPage']);
Route::get('/register', ['uses' => 'HomeController@showRegisterPage']);

Route::post('/register', ['uses' => 'HomeController@register']);
Route::post('/login', ['uses' => 'HomeController@login']);

Route::group(['before' => 'auth'], function(){
	
	Route::get('recipe/full', ['as' => 'recipe.full', 'uses' => 'RecipeController@showFull']);
	Route::get('/home', ['uses' => 'HomeController@showHomePage']);
	Route::get('/logout', ['uses' => 'HomeController@logout']);
	Route::post('recipe/only', ['as' => 'recipe.only', 'uses' => 'RecipeController@showOnly']);
	Route::post('recipe/with', ['as' => 'recipe.with', 'uses' => 'RecipeController@showWith']);
	Route::post('recipe/some', ['as' => 'recipe.some', 'uses' => 'RecipeController@showSome']);
	Route::post('recipe/search', ['as' => 'recipe.search', 'uses' => 'RecipeController@showSearch']);
	Route::resource('ingredient', 'IngredientController');
	Route::resource('recipe', 'RecipeController');
	Route::get('ingredient/all', ['as' => 'ingredient.all', 'uses' => 'IngredientController@showAll']);

});
