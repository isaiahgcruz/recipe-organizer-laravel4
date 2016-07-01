<?php

class Recipe extends Eloquent {


	protected $fillable = ['name', 'instruction', 'type'];
	public static $types = [ 1=>'Filipino', 2=> 'Japanese'];


	public static function getOnly($data)
	{
		$recipes = Recipe::select('id','name','type')->whereHas('ingredients',function($q) {
				$q->whereIn('ingredient_id', Request::input('ingredients'));
		})->whereRaw(count($data).' = (select count(*) from `ingredient_recipe` where `recipe_id` = `recipes`.`id`)')->with('ingredients')->paginate(5);
		return $recipes;
	}

	public static function getWith($data)
	{
		return $recipes = DB::table('ingredient_recipe')->select('*', DB::raw('count(*) as `count`'))->whereIn('ingredient_id',Request::input('ingredients'))->having('count', '=',count(Request::input('ingredients')))->groupBy('recipe_id')->join('recipes', 'recipes.id' , '=', 'recipe_id')->paginate(5);
	}

	public static function getSome()
	{
		return Recipe::whereHas('ingredients', function($q) {
			$q->whereIn('ingredient_id', Request::input('ingredients'));
		})->with('ingredients')->paginate(5);
	}

	public static function getTypes()
	{
		return self::$types;
	}



	public function getTypeAttribute($value)
	{
		return self::$types[$value];
	}

	private $rules = [ 'name' => 'required|min:3|max:20', 'type' => 'required', 'instruction' => 'required', 'ingredients' => 'required'];

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


	public function ingredients()
	{
		return $this->belongsToMany('Ingredient');
	}
}