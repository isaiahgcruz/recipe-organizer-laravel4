<?php

class Ingredient extends Eloquent {
	
	protected $fillable = ['name' , 'type'];

	private $rules = [ 'name' => 'required|min:3|max:20', 'type' => 'required'];

	private $errors;

	public function validate($data)
	{
		$validator = Validator::make($data, $this->rules);
		if ($validator->fails())
		{
			$this->errors = $validator->errors();
			return false;
		}
		return true;
	}

	public function errors()
	{
		return $this->errors;
	}

	public function type()
	{

	}

	public function recipes()
	{
		return $this->belongsToMany('Recipe');
	}

	public static function getIngredientsList()
	{
		return $ingredients = Ingredient::select('id', 'name', 'type')->orderBy('type','asc')->orderBy('name', 'asc')->lists('id', 'name');
		
	}

	public static function getIngredientsListByType()
	{
		$ingredients = Ingredient::select(DB::raw('`lookups`.`description` as type_name, group_concat(ingredients.id) as id'), DB::raw('group_concat(name) as name'), 'type')->join('lookups', function($q) {
			$q->on('lookups.value','=','ingredients.type')->where('lookups.keyword', '=', 'ingredient_type');
		})
		->orderBy('type','asc')->orderBy('name', 'asc')->groupBy('type', 'lookups.description')->get();
		
		$groupedIngredients = [];
		foreach($ingredients as $ingredient)
			{
			$ids = explode(",",$ingredient->id);
			$names = explode(",",$ingredient->name);
			$children = [];
			for ($i=0; $i < count($names); $i++) { 
				array_push($children, ['id' => $ids[$i], 'text' => $names[$i]]);
			}
			$array = ['text' => $ingredient->type_name, 'children' => $children];
			array_push($groupedIngredients, $array);
		}

		return $groupedIngredients;
		
	}

}