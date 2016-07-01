<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		// $this->call('UserTableSeeder');
		$this->call('LookupTableSeeder');
	}

}


class LookupTableSeeder extends Seeder {
	public function run()
	{
		DB::table('lookups')->truncate();
		//Lookup::create(['keyword' => '', 'value' => '', 'description' => '']);
		Lookup::create(['keyword' => 'ingredient_type', 'value' => '1', 'description' => 'vegetable']);
		Lookup::create(['keyword' => 'ingredient_type', 'value' => '2', 'description' => 'chicken']);
		Lookup::create(['keyword' => 'ingredient_type', 'value' => '3', 'description' => 'pork']);
		Lookup::create(['keyword' => 'ingredient_type', 'value' => '4', 'description' => 'fish']);
		Lookup::create(['keyword' => 'ingredient_type', 'value' => '5', 'description' => 'beef']);
		Lookup::create(['keyword' => 'ingredient_type', 'value' => '6', 'description' => 'fruit']);
		Lookup::create(['keyword' => 'ingredient_type', 'value' => '7', 'description' => 'etc']);
	}
}