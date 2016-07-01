<?php

class RecipeController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		$recipe_types = Recipe::getTypes();
		$ingredients_list = Ingredient::getIngredientsList();
		$recipes = Recipe::all();
		return View::make('recipes.index', compact('recipe_types', 'ingredients_list', 'recipes'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}



	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$recipe = new Recipe;
		Request::merge(array_map('trim', Request::except('ingredients')));

		if ($recipe->validate(Request::all()))
		{
			//return Request::except('_token');
			$recipe = $recipe->create(Request::except('ingredients'));
			$recipe->ingredients()->attach(Request::input('ingredients'));
			return ['alert' => 'success', 'status' => '1', 'data' => 'recipe', 'messages' => ['Recipe successfuly added']];
		}
		else
		{
			$messages = $recipe->errors()->all();
			//return View::make('auth.register',compact('messages'))->withAlert('danger')->withInput(Request::all());
			return ['alert' => 'danger', 'status' => '0', 'data' => 'recipe', 'messages' => $messages];
		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
		//$recipe = Recipe::where('id', $id)->with('ingredients')->get();
		$recipe = Recipe::find($id);
		$recipe->ingredients;
		//return $recipe;
		return View::make('recipes.show', compact('recipe'));
	}

	public function showFull()
	{
		$recipes = Recipe::where('id','>','-1')->with('ingredients')->paginate(5);
		return View::make('recipes.full', compact('recipes'));	
	}
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function showOnly()
	{

		// all are required
		$recipes = Recipe::getOnly(Request::input('ingredients'));
		return self::showRecipeResult('recipe.only', 'Recipes that contains only the ff ingredients', $recipes);
		//return $recipes;
	}

	public function showWith()
	{
		/*$recipes = Recipe::whereHas('ingredients',function($q) {
				$q->where('ingredient_id', Request::input('ingredients'));
		}, '=', count(Request::input('ingredients')))->with('ingredients')->get();*/
		$recipes = Recipe::getWith(Request::input('ingredients'));
		return self::showRecipeResult('recipe.with', 'Recipes that contains all the ff ingredients', $recipes);
		//return DB::getQueryLog();
		//return $recipes;
	}


	public function showSome()
	{
		$recipes = Recipe::getSome();
		return self::showRecipeResult('recipe.some', 'Recipes that contains some the ff ingredients', $recipes);
	}

	public function showRecipeResult($route, $search, $results)
	{
		$ingredients_grouped = json_encode(Ingredient::getIngredientsListByType());
		$ingredients_selected = json_encode(Request::input('ingredients'));
		$this->route = $route;
		$searchMsg = $search;
		$recipes = $results;
		$ingredients_list = Ingredient::getIngredientsList();
		return View::make('recipes.result', compact('route', 'searchMsg', 'recipes', 'ingredients_list', 'ingredients_selected', 'ingredients_grouped'));
	}

	public function showSearch()
	{
		$recipe_name = Request::input('name');
		$recipes = Recipe::where('name', 'like', "%$recipe_name%")->orderBy('name')->paginate(5);
		
		return View::make('recipes.search', compact('recipes', 'recipe_name'));
	}



}
