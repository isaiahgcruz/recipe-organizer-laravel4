<?php

class Lookup extends Eloquent 
{
	protected $fillable = ['keyword', 'value', 'description'];

	public static function getIngredientTypes()
	{
		return Lookup::select('keyword','value','description')->where('keyword', 'ingredient_type')->lists('description','value');
	}
	
}