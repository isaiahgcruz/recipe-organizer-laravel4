<?php

class IngredientController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		
		$ingredient_types = Lookup::getIngredientTypes();
		//$ingredient_types = array_map('ucfirst', $ingredient_types);
		$ingredients = Ingredient::select('ingredients.id','name', 'lookups.description as type')->join('lookups', function($join)
        {
            $join->on('lookups.value', '=', 'ingredients.type')
                 ->where('lookups.keyword', '=', 'ingredient_type');
        })->orderBy('type')->get();		
        
        //return $ingredients;
		return View::make('ingredients.index', compact('ingredient_types', 'ingredients'));
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
		//
		$ingredient = new Ingredient;
		Request::merge(array_map('trim', Request::all()));

		if ($ingredient->validate(Request::all()))
		{
			//return Request::except('_token');
			$ingredient->create(Request::all());
			return ['alert' => 'success', 'status' => '1', 'data' => 'ingredient', 'messages' => ['Ingredient successfuly added']];
		}
		else
		{
			$messages = $ingredient->errors()->all();

			//return View::make('auth.register',compact('messages'))->withAlert('danger')->withInput(Request::all());
			return ['alert' => 'danger', 'status' => '0', 'data' => 'ingredient', 'messages' => $messages];
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
		$ingredient_types = Lookup::getIngredientTypes();
		$ingredient = Ingredient::find($id);
		return View::make('ingredients.edit', compact('ingredient','ingredient_types'));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		Request::merge(array_map('trim', Request::all()));
		$ingredient = Ingredient::find($id);

		
		if ($ingredient->validate(Request::all()))
		{
			//return Request::except('_token');
			//return Request::except('_token', '_method');
			$ingredient->update(Request::except('_token', '_method'));

			return ['alert' => 'success', 'status' => '1', 'data' => 'ingredient', 'messages' => ['Ingredient successfuly updated']];
		}
		else
		{
			$messages = $ingredient->errors()->all();

			//return View::make('auth.register',compact('messages'))->withAlert('danger')->withInput(Request::all());
			return ['alert' => 'danger', 'status' => '0', 'data' => 'ingredient', 'messages' => $messages];
		}
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

	public function showAll()
	{
		return (Response::json(Ingredient::select('name', 'type')->get()));
		return Ingredient::select('name', 'type')->get();
	}

}
