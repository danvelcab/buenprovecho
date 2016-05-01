<?php

class ScrappingController extends BaseController {

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

	public function cookpad2()
	{
		//en el futuro hasta 81.
		for($n = 32; $n<=37; $n++){
			$new_fichero = file_get_contents("https://cookpad.com/es?page=".$n);
			$more_recipes = true;
			$urls = array();
			while($more_recipes){
				$pos = strpos($new_fichero, "feed_recipe");
				$new_fichero = substr($new_fichero, $pos, strlen($new_fichero));

				$pos_href = strpos($new_fichero, "href");
				$new_fichero = substr($new_fichero, $pos_href+6, strlen($new_fichero));
				$pos_end_href = strpos($new_fichero, '"');
				$url = "https://cookpad.com".substr($new_fichero,0,$pos_end_href);
				$new_fichero = substr($new_fichero, $pos_end_href+6, strlen($new_fichero));

				$pos_img = strpos($new_fichero, "src");
				$new_fichero = substr($new_fichero, $pos_img+5, strlen($new_fichero));
				$pos_end_img = strpos($new_fichero, '"');
				$foto = substr($new_fichero,0,$pos_end_img);
				$new_fichero = substr($new_fichero, $pos_end_img, strlen($new_fichero));

				$pos_title = strpos($new_fichero, "feed__title");
				$new_fichero = substr($new_fichero, $pos_title+26, strlen($new_fichero));
				$pos_end_title = strpos($new_fichero, '<');
				$title = substr($new_fichero,0,$pos_end_title);
				$new_fichero = substr($new_fichero, $pos_end_title, strlen($new_fichero));

				array_push($urls, array('url' => $url, "image_url" => $foto, "title" => $title));

				$pos = strpos($new_fichero, "feed_recipe");
				if(!$pos){
					$more_recipes = false;
				}
			}
			foreach($urls as $url){
				$new_fichero = file_get_contents($url['url']);
				$pos_time = strpos($new_fichero, 'pattern="\d*">');
				if($pos_time == false){
					$time = 0;
				}else{
					$new_fichero = substr($new_fichero, $pos_time+6, strlen($new_fichero));
					$pos_end_time = strpos($new_fichero, ' minutos');
					$time = "https://cookpad.com".substr($new_fichero,0,$pos_end_time);
					$new_fichero = substr($new_fichero, $pos_end_time, strlen($new_fichero));
				}
				$more_ingredients = true;
				$ingredients = array();
				while($more_ingredients){
					$pos_ingredient = strpos($new_fichero, "ingredient__attribute--name");
					$new_fichero = substr($new_fichero, $pos_ingredient+29, strlen($new_fichero));
					$pos_end_ingredient = strpos($new_fichero, '</span>');
					$ingredient = substr($new_fichero,0,$pos_end_ingredient);
					$new_fichero = substr($new_fichero, $pos_end_ingredient, strlen($new_fichero));
					$pos_ingredient = strpos($new_fichero, "ingredient__attribute--name");
					array_push($ingredients, $ingredient);
					if(!$pos_ingredient){
						$more_ingredients = false;
					}
				}
				//Empieza el guardado
//				$recipe = new Recipes();
//				$recipe->name = $url['title'];
//				$recipe->url = $url['url'];
//				$recipe->time = $time;
//				$recipe->image_url = $url['image_url'];
//				$recipe->save();


				foreach($ingredients as $i){
					$i = strtolower($i);
					$ingredientDB = DB::table('ingredients')->where('name','=',$i)->first();
					if($ingredientDB == null){
						$ingredient = new Ingredients();
						$ingredient->name = $i;
						$ingredient->save();
//						$ingredient->recipes()->attach($recipe->id);
//						$ingredient->save();
					}
				}



			}
			echo $new_fichero;
		}

	}

	public function cookpad3()
	{
		$ingredientsDB = Ingredients::all();
		$index_parecidos = 0;
		$index_no_parecidos = 0;
		//en el futuro hasta 81.
		for($n = 70; $n<=81; $n++){
			$new_fichero = file_get_contents("https://cookpad.com/es?page=".$n);
			$more_recipes = true;
			$urls = array();
			while($more_recipes){
				$pos = strpos($new_fichero, "feed_recipe");
				$new_fichero = substr($new_fichero, $pos, strlen($new_fichero));

				$pos_href = strpos($new_fichero, "href");
				$new_fichero = substr($new_fichero, $pos_href+6, strlen($new_fichero));
				$pos_end_href = strpos($new_fichero, '"');
				$url = "https://cookpad.com".substr($new_fichero,0,$pos_end_href);
				$new_fichero = substr($new_fichero, $pos_end_href+6, strlen($new_fichero));

				$pos_img = strpos($new_fichero, "src");
				$new_fichero = substr($new_fichero, $pos_img+5, strlen($new_fichero));
				$pos_end_img = strpos($new_fichero, '"');
				$foto = substr($new_fichero,0,$pos_end_img);
				$new_fichero = substr($new_fichero, $pos_end_img, strlen($new_fichero));

				$pos_title = strpos($new_fichero, "feed__title");
				$new_fichero = substr($new_fichero, $pos_title+26, strlen($new_fichero));
				$pos_end_title = strpos($new_fichero, '<');
				$title = substr($new_fichero,0,$pos_end_title);
				$new_fichero = substr($new_fichero, $pos_end_title, strlen($new_fichero));

				array_push($urls, array('url' => $url, "image_url" => $foto, "title" => $title));

				$pos = strpos($new_fichero, "feed_recipe");
				if(!$pos){
					$more_recipes = false;
				}
			}
			foreach($urls as $url){
				$new_fichero = file_get_contents($url['url']);
				$pos_time = strpos($new_fichero, 'pattern="\d*">');
				if($pos_time == false){
					$time = 0;
				}else{
					$new_fichero = substr($new_fichero, $pos_time+6, strlen($new_fichero));
					$pos_end_time = strpos($new_fichero, ' minutos');
					$time = "https://cookpad.com".substr($new_fichero,0,$pos_end_time);
					$new_fichero = substr($new_fichero, $pos_end_time, strlen($new_fichero));
				}
				$more_ingredients = true;
				$ingredients = array();
				while($more_ingredients){
					$pos_ingredient = strpos($new_fichero, "ingredient__attribute--name");
					$new_fichero = substr($new_fichero, $pos_ingredient+29, strlen($new_fichero));
					$pos_end_ingredient = strpos($new_fichero, '</span>');
					$ingredient = substr($new_fichero,0,$pos_end_ingredient);
					$new_fichero = substr($new_fichero, $pos_end_ingredient, strlen($new_fichero));
					$pos_ingredient = strpos($new_fichero, "ingredient__attribute--name");
					array_push($ingredients, $ingredient);
					if(!$pos_ingredient){
						$more_ingredients = false;
					}
				}
				//Empieza el guardado
//				$recipe = new Recipes();
//				$recipe->name = $url['title'];
//				$recipe->url = $url['url'];
//				$recipe->time = $time;
//				$recipe->image_url = $url['image_url'];
//				$recipe->save();

				$parecidos_table = array();
				foreach($ingredients as $i){
					$parecidos = array();
					$i = strtolower($i);
					$i = $this->elimina_acentos($i);
					foreach($ingredientsDB as $ingredientDB){
						if(strpos(" ".$i,$ingredientDB->search) != false) {
							array_push($parecidos, $ingredientDB->search);
							break;
						}
					}
					if(sizeof($parecidos) == 0){
						$index_no_parecidos++;
						$ingredient = new Ingredients();
						$ingredient->name = $i;
						$ingredient->search = $i;
						try{
							$ingredient->save();
						}catch(Exception $e){
							$e = "HOLA";

						}
					}else{
						$index_parecidos++;
					}
				}
			}
			echo "TERMINADO ".$index_parecidos." ".$index_no_parecidos;
		}

	}

	//Solo se ha hecho hasta la página 29. Empezar posteriormente por la 30.
	public function cookpad()
	{
		$ingredientsDB = DB::table('ingredients')
			->whereNull('ingredients_id')
			->get();
		$index_parecidos = 0;
		$index_no_parecidos = 0;
		//en el futuro hasta 81.
		for($n = 20; $n<=29; $n++){
			$new_fichero = file_get_contents("https://cookpad.com/es?page=".$n);
			$more_recipes = true;
			$urls = array();
			while($more_recipes){
				$pos = strpos($new_fichero, "feed_recipe");
				$new_fichero = substr($new_fichero, $pos, strlen($new_fichero));

				$pos_href = strpos($new_fichero, "href");
				$new_fichero = substr($new_fichero, $pos_href+6, strlen($new_fichero));
				$pos_end_href = strpos($new_fichero, '"');
				$url = "https://cookpad.com".substr($new_fichero,0,$pos_end_href);
				$new_fichero = substr($new_fichero, $pos_end_href+6, strlen($new_fichero));

				$pos_img = strpos($new_fichero, "src");
				$new_fichero = substr($new_fichero, $pos_img+5, strlen($new_fichero));
				$pos_end_img = strpos($new_fichero, '"');
				$foto = substr($new_fichero,0,$pos_end_img);
				$new_fichero = substr($new_fichero, $pos_end_img, strlen($new_fichero));

				$pos_title = strpos($new_fichero, "feed__title");
				$new_fichero = substr($new_fichero, $pos_title+26, strlen($new_fichero));
				$pos_end_title = strpos($new_fichero, '<');
				$title = substr($new_fichero,0,$pos_end_title);
				$new_fichero = substr($new_fichero, $pos_end_title, strlen($new_fichero));

				array_push($urls, array('url' => $url, "image_url" => $foto, "title" => $title));

				$pos = strpos($new_fichero, "feed_recipe");
				if(!$pos){
					$more_recipes = false;
				}
			}
			foreach($urls as $url){
				$new_fichero = file_get_contents($url['url']);
				$pos_time = strpos($new_fichero, 'pattern="\d*">');
				if($pos_time == false){
					$time = 0;
				}else{
					$new_fichero = substr($new_fichero, $pos_time+6, strlen($new_fichero));
					$pos_end_time = strpos($new_fichero, ' minutos');
					$time = "https://cookpad.com".substr($new_fichero,0,$pos_end_time);
					$new_fichero = substr($new_fichero, $pos_end_time, strlen($new_fichero));
				}
				$more_ingredients = true;
				$ingredients = array();
				while($more_ingredients){
					$pos_ingredient = strpos($new_fichero, "ingredient__attribute--name");
					$new_fichero = substr($new_fichero, $pos_ingredient+29, strlen($new_fichero));
					$pos_end_ingredient = strpos($new_fichero, '</span>');
					$ingredient = substr($new_fichero,0,$pos_end_ingredient);
					$new_fichero = substr($new_fichero, $pos_end_ingredient, strlen($new_fichero));
					$pos_ingredient = strpos($new_fichero, "ingredient__attribute--name");
					array_push($ingredients, $ingredient);
					if(!$pos_ingredient){
						$more_ingredients = false;
					}
				}
				foreach($ingredients as $i){
					$parecidos = array();
					$i = strtolower($i);
					$i = $this->elimina_acentos($i);
					foreach($ingredientsDB as $ingredientDB){
						if(strpos(" ".$i,$ingredientDB->search) != false) {
							$sub_ingredients = DB::table('ingredients')->where('ingredients_id','=',$ingredientDB->id)->get();
							foreach($sub_ingredients as $si){
								if(strpos(" ".$i, $si->search)){
									array_push($parecidos, $si->search);
									break;
								}
							}
							if(sizeof($parecidos) == 0){
								$index_no_parecidos++;
								$ingredient = new \Ingredients\Ingredients();
								$ingredient->name = $i;
								$ingredient->search = $i;
								$ingredient->ingredients_id = $ingredientDB->id;
								try{
									$ingredient->save();
								}catch(Exception $e){
									$e = "HOLA";

								}
							}else{
								$index_parecidos++;
							}

							break;
						}

					}
				}
			}
			echo "TERMINADO ".$index_parecidos." ".$index_no_parecidos;
		}

	}

	public function cookpadRecipes()
	{
		$ingredientsDB = DB::table('ingredients')
			->whereNull('ingredients_id')
			->get();
		$subIngredientsDB = DB::table('ingredients')
			->whereNotNull('ingredients_id')
			->get();
		//en el futuro hasta 81.
		for($n = 21; $n<=21; $n++){
			$new_fichero = file_get_contents("https://cookpad.com/es?page=".$n);
			$more_recipes = true;
			$urls = array();
			while($more_recipes){
				$pos = strpos($new_fichero, "feed_recipe");
				$new_fichero = substr($new_fichero, $pos, strlen($new_fichero));

				$pos_href = strpos($new_fichero, "href");
				$new_fichero = substr($new_fichero, $pos_href+6, strlen($new_fichero));
				$pos_end_href = strpos($new_fichero, '"');
				$url = "https://cookpad.com".substr($new_fichero,0,$pos_end_href);
				$new_fichero = substr($new_fichero, $pos_end_href+6, strlen($new_fichero));


				$pos_title = strpos($new_fichero, "feed__title");
				$new_fichero = substr($new_fichero, $pos_title+26, strlen($new_fichero));
				$pos_end_title = strpos($new_fichero, '<');
				$title = substr($new_fichero,0,$pos_end_title);
				$new_fichero = substr($new_fichero, $pos_end_title, strlen($new_fichero));

				array_push($urls, array('url' => $url, "title" => $title));

				$pos = strpos($new_fichero, "feed_recipe");
				if(!$pos){
					$more_recipes = false;
				}
			}
			foreach($urls as $url){
				$num_ingredients = 0;
				$new_fichero = file_get_contents($url['url']);

				$pos_img = strpos($new_fichero, "tofu_image");
				$new_fichero = substr($new_fichero, $pos_img+5, strlen($new_fichero));
				$pos_img = strpos($new_fichero, "src");
				$new_fichero = substr($new_fichero, $pos_img+5, strlen($new_fichero));
				$pos_end_img = strpos($new_fichero, '"');
				$foto = substr($new_fichero,0,$pos_end_img);
				$new_fichero = substr($new_fichero, $pos_end_img, strlen($new_fichero));

				$pos_time = strpos($new_fichero, 'time">');
				if($pos_time == false){
					$time = 0;
				}else{
					$new_fichero = substr($new_fichero, $pos_time+8, strlen($new_fichero));
					$pos_end_time = strpos($new_fichero, ' minutos');
					$time = intval(substr($new_fichero,0,$pos_end_time));
					$new_fichero = substr($new_fichero, $pos_end_time, strlen($new_fichero));
				}
				$more_ingredients = true;
				$ingredients = array();
				while($more_ingredients){
					$pos_ingredient = strpos($new_fichero, "ingredient__attribute--name");
					$new_fichero = substr($new_fichero, $pos_ingredient+29, strlen($new_fichero));
					$pos_end_ingredient = strpos($new_fichero, '</span>');
					$ingredient = substr($new_fichero,0,$pos_end_ingredient);
					$new_fichero = substr($new_fichero, $pos_end_ingredient, strlen($new_fichero));
					$pos_ingredient = strpos($new_fichero, "ingredient__attribute--name");
					array_push($ingredients, $ingredient);
					if(!$pos_ingredient){
						$more_ingredients = false;
					}
				}
				//				$recipe = new Recipes();
				$recipe = new \Recipes\Recipes();
				$recipe->name = $url['title'];
				$recipe->url = $url['url'];
				$recipe->time = $time;
				$recipe->image_url = $foto;
				$recipe->save();

				foreach($ingredients as $i){
					$i = strtolower($i);
					$i = $this->elimina_acentos($i);
					$exist_ingredient = false;
					$ingredients_parecidos = array();
					foreach($ingredientsDB as $ingredientDB){
						if(strpos(" ".$i,$ingredientDB->search) != false) {
							array_push($ingredients_parecidos, $ingredientDB);
						}
					}
					$index = 0;
					for($o = 0;$o<sizeof($ingredients_parecidos);$o++){
						if(strlen($ingredients_parecidos[$o]->search)>strlen($ingredients_parecidos[$index]->search)){
							$index = $o;
						}
					}
					if(sizeof($ingredients_parecidos)>0){
						$sub_ingredients = DB::table('ingredients')->where('ingredients_id','=',$ingredients_parecidos[$index]->id)->get();
						$exist_sub_ingredient = false;
						foreach($sub_ingredients as $si){
							if(strpos(" ".$i, $si->search)){
								$exist_sub_ingredient = true;
								$recipe->ingredients()->attach($si->id);
								$num_ingredients++;
								$recipe->save();
								break;
							}
						}
						if(!$exist_sub_ingredient){
							$recipe->ingredients()->attach($ingredients_parecidos[$index]->id);
							$num_ingredients++;
							$recipe->save();
						}
					}else{
						foreach($subIngredientsDB as $si){
							if(strpos(" ".$i, $si->search)){
								$recipe->ingredients()->attach($si->id);
								$num_ingredients++;
								$recipe->save();
								break;
							}
						}
					}
				}
				$recipe->num_ingredients = $num_ingredients;
				$recipe->save();
			}
		}
		echo "TERMINADO ";
	}

	function elimina_acentos($text)
	{
		$text = htmlentities($text, ENT_QUOTES, 'UTF-8');
		$text = strtolower($text);
		$patron = array (
			// Espacios, puntos y comas por guion
			//'/[\., ]+/' => ' ',

			// Vocales
			'/\+/' => '',
			'/&agrave;/' => 'a',
			'/&egrave;/' => 'e',
			'/&igrave;/' => 'i',
			'/&ograve;/' => 'o',
			'/&ugrave;/' => 'u',

			'/&aacute;/' => 'a',
			'/&eacute;/' => 'e',
			'/&iacute;/' => 'i',
			'/&oacute;/' => 'o',
			'/&uacute;/' => 'u',

			'/&acirc;/' => 'a',
			'/&ecirc;/' => 'e',
			'/&icirc;/' => 'i',
			'/&ocirc;/' => 'o',
			'/&ucirc;/' => 'u',

			'/&atilde;/' => 'a',
			'/&etilde;/' => 'e',
			'/&itilde;/' => 'i',
			'/&otilde;/' => 'o',
			'/&utilde;/' => 'u',

			'/&auml;/' => 'a',
			'/&euml;/' => 'e',
			'/&iuml;/' => 'i',
			'/&ouml;/' => 'o',
			'/&uuml;/' => 'u',

			'/&auml;/' => 'a',
			'/&euml;/' => 'e',
			'/&iuml;/' => 'i',
			'/&ouml;/' => 'o',
			'/&uuml;/' => 'u',

			// Otras letras y caracteres especiales
			'/&aring;/' => 'a',
			'/&ntilde;/' => 'ñ',

			// Agregar aqui mas caracteres si es necesario

		);

		$text = preg_replace(array_keys($patron),array_values($patron),$text);
		return $text;
	}
}
