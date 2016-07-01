<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		//$ingredients_list = Ingredient::getIngredientsList();
		return View::make('hello', compact('ingredients_list'));
	}

	public function showLoginPage()
	{
		return View::make('auth.login');
	}

	public function showRegisterPage() 
	{
		return View::make('auth.register');
	}
	
	public function register()
	{
		$user = new User;
		Request::merge(array_map('trim', Request::all()));

		if ($user->validate(Request::all()))
		{
			$user->create(Request::all());
			$messages = ['Account successfuly created!'];
			return View::make('auth.register',compact('messages'))->withAlert('success');
		}
		else
		{
			$messages = $user->errors()->all();
			return View::make('auth.register',compact('messages'))->withAlert('danger')->withInput(Request::all());
		}
	}

	public function login()
	{
		if (Auth::attempt(['email' => Request::input('email'), 'password' => Request::input('password')]))
		{
			return Redirect::to('home');
		}
		else
		{
			$messages = ['Invalid login credentials'];
			return View::make('auth.login',compact('messages'))->withAlert('danger');
		}
	}

	public function logout()
	{
		Auth::logout();
	}

	public function showHomePage()
	{
		$ingredients_list = array_flip(Ingredient::getIngredientsList());
		//return Ingredient::getIngredientsListByType();
		$ingredients_grouped = json_encode(Ingredient::getIngredientsListByType());
		//return $ingredients_grouped;
		return View::make('home	', compact('ingredients_list', 'ingredients_grouped'));
	}
}
