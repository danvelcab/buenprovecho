<?php

class RecipeController extends BaseController {

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

	public function findRecipes()
	{
		$recipes = DB::table('recipes')->join('ingredients_recipes','ingredients_recipes.recipes_id','=','recipes.id');
		$selected_ingredients = array();
		$ingredients = array();
		$selected_ingredients_object = array();
		$suggestions = array();
		$recipes_final = array();
		if(isset(Input::all()['ingredients'])){
			$selected_ingredients = Input::all()['ingredients'];
			foreach($selected_ingredients as $ingredient){
				$recipes = $recipes->orWhere('ingredients_recipes.ingredients_id','=',$ingredient);
			}
			$recipes = $recipes->get();
			$recipe_table = array();
			foreach($recipes as $recipe){
				if(!isset($recipe_table[$recipe->recipes_id])){
					$recipe_table[$recipe->recipes_id] = 1/$recipe->num_ingredients;
				}else{
					$recipe_table[$recipe->recipes_id] = $recipe_table[$recipe->recipes_id] + 1/$recipe->num_ingredients;
				}
			}
			function clean($var){
				if($var < 0.8){
					return false;
				}else{
					return true;
				}
			}
			function cleanForSuggestion($var){
				if($var < 0.5){
					return false;
				}else{
					return true;
				}
			}
			$valid_recipe_table = array_filter($recipe_table, "clean");
			arsort($valid_recipe_table);
			$recipes_final = \Recipes\Recipes::find(array_keys($valid_recipe_table));
			$invalid_recipe_table = array_filter($recipe_table, "cleanForSuggestion");
			$invalid_recipes = \Recipes\Recipes::find(array_keys($invalid_recipe_table));
			$ingredients_more_used = array();
			foreach($invalid_recipes as $recipe){
				foreach($recipe->ingredients()->get() as $ingredient){
					if(!in_array($ingredient->id, $selected_ingredients)){
						if(!isset($ingredients_more_used[$ingredient->id])){
							$ingredients_more_used[$ingredient->id] = 1/$recipe->num_ingredients;
						}else{
							$ingredients_more_used[$ingredient->id] = $ingredients_more_used[$ingredient->id] + 1/$recipe->num_ingredients;
						}
					}
				}
			}
			arsort($ingredients_more_used);
			if(sizeof($ingredients_more_used)>6){
				$ingredients_more_used = array_chunk($ingredients_more_used, 6, true);
				$suggestions = \Ingredients\Ingredients::find(array_keys($ingredients_more_used[0]));
			}else{
				$suggestions = \Ingredients\Ingredients::find(array_keys($ingredients_more_used));
			}
			$ingredients = \Ingredients\Ingredients::all();
			$selected_ingredients_object = \Ingredients\Ingredients::find($selected_ingredients);
		}
		return View::make('recipes.list', array('ingredients' => $ingredients, 'selected_ingredients' => $selected_ingredients,
			'selected_ingredients_object' => $selected_ingredients_object, 'recipes' => $recipes_final, 'sugerencias' => $suggestions));
	}
	public function findRecipesWithSuggestions()
	{
		$recipes = DB::table('recipes')->join('ingredients_recipes','ingredients_recipes.recipes_id','=','recipes.id');
		$selected_ingredients = array();
		foreach(Input::all() as $key =>$ingredient){
			if($ingredient == "on");
			array_push($selected_ingredients,$key);
		}
		foreach($selected_ingredients as $ingredient){
			$recipes = $recipes->orWhere('ingredients_recipes.ingredients_id','=',$ingredient);
		}
		$recipes = $recipes->get();
		$recipe_table = array();
		foreach($recipes as $recipe){
			if(!isset($recipe_table[$recipe->recipes_id])){
				$recipe_table[$recipe->recipes_id] = 1/$recipe->num_ingredients;
			}else{
				$recipe_table[$recipe->recipes_id] = $recipe_table[$recipe->recipes_id] + 1/$recipe->num_ingredients;
			}
		}
		function clean($var){
			if($var < 0.8){
				return false;
			}else{
				return true;
			}
		}
		function cleanForSuggestion($var){
			if($var < 0.5){
				return false;
			}else{
				return true;
			}
		}
		$valid_recipe_table = array_filter($recipe_table, "clean");
		arsort($valid_recipe_table);
		$recipes_final = \Recipes\Recipes::find(array_keys($valid_recipe_table));
		$invalid_recipe_table = array_filter($recipe_table, "cleanForSuggestion");
		$invalid_recipes = \Recipes\Recipes::find(array_keys($invalid_recipe_table));
		$ingredients_more_used = array();
		foreach($invalid_recipes as $recipe){
			foreach($recipe->ingredients()->get() as $ingredient){
				if(!in_array($ingredient->id, $selected_ingredients)){
					if(!isset($ingredients_more_used[$ingredient->id])){
						$ingredients_more_used[$ingredient->id] = 1/$recipe->num_ingredients;
					}else{
						$ingredients_more_used[$ingredient->id] = $ingredients_more_used[$ingredient->id] + 1/$recipe->num_ingredients;
					}
				}
			}
		}
		arsort($ingredients_more_used);
		if(sizeof($ingredients_more_used)>6){
			$ingredients_more_used = array_chunk($ingredients_more_used, 6, true);
			$suggestions = \Ingredients\Ingredients::find(array_keys($ingredients_more_used[0]));
		}else{
			$suggestions = \Ingredients\Ingredients::find(array_keys($ingredients_more_used));
		}
		$ingredients = \Ingredients\Ingredients::all();
		$selected_ingredients_object = \Ingredients\Ingredients::find($selected_ingredients);
		return View::make('recipes.list', array('ingredients' => $ingredients, 'selected_ingredients' => $selected_ingredients,
			'selected_ingredients_object' => $selected_ingredients_object, 'recipes' => $recipes_final, 'sugerencias' => $suggestions));
	}

	public function findAllRecipes()
	{
		$recipes_final = \Recipes\Recipes::all();
		$ingredients = \Ingredients\Ingredients::all();
		$selectes_ingredients = \Ingredients\Ingredients::find(array(168,169,170));
		return View::make('recipes.list', array('ingredients' => $ingredients, 'selected_ingredients' => $selectes_ingredients,'recipes' => $recipes_final));
	}

}