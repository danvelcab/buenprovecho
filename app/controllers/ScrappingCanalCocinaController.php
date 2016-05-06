<?php

class ScrappingCanalCocinaController extends BaseController {

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
//	canalcocina.es
	//250 paginacion
	public function getBasicIngredients()
	{
		$ingredientsDB = DB::table('ingredients')
			->whereNull('ingredients_id')
			->get();
		for($n = 1; $n<=180; $n++){
			if($n%4==0){
				$a = "";
			}
			$url_busqueda = "http://canalcocina.es/recetas/buscar/pag/".$n."/";
			$new_fichero = file_get_contents($url_busqueda);
			$more_recipes = true;
			$urls = array();
			while($more_recipes){
				$pos = strpos($new_fichero, "ribbon");
				$new_fichero = substr($new_fichero, $pos, strlen($new_fichero));

				$pos_href = strpos($new_fichero, "href");
				$new_fichero = substr($new_fichero, $pos_href+6, strlen($new_fichero));
				$pos_end_href = strpos($new_fichero, '"');
				$url = "http://canalcocina.es/".substr($new_fichero,0,$pos_end_href);
				if(strpos($url,"video") == false){
					$new_fichero = substr($new_fichero, $pos_end_href+6, strlen($new_fichero));

					$pos_img = strpos($new_fichero, "src");
					$new_fichero = substr($new_fichero, $pos_img+5, strlen($new_fichero));
					$pos_end_img = strpos($new_fichero, '"');
					$foto = substr($new_fichero,0,$pos_end_img);
					$new_fichero = substr($new_fichero, $pos_end_img, strlen($new_fichero));

//					$pos_title = strpos($new_fichero, "title");
//					$new_fichero = substr($new_fichero, $pos_title+26, strlen($new_fichero));
//					$pos_end_title = strpos($new_fichero, '<');
//					$title = substr($new_fichero,0,$pos_end_title);
//					$new_fichero = substr($new_fichero, $pos_end_title, strlen($new_fichero));

					array_push($urls, array('url' => $url, "image_url" => $foto,
//						"title" => $title
					));

					$pos = strpos($new_fichero, "recipe");
					if(!$pos){
						$more_recipes = false;
					}
				}
			}
			foreach($urls as $url){
				$new_fichero = file_get_contents($url['url']);
//				$pos_time = strpos($new_fichero, 'pattern="\d*">');
//				if($pos_time == false){
//					$time = 0;
//				}else{
//					$new_fichero = substr($new_fichero, $pos_time+6, strlen($new_fichero));
//					$pos_end_time = strpos($new_fichero, ' minutos');
//					$time = "https://cookpad.com".substr($new_fichero,0,$pos_end_time);
//					$new_fichero = substr($new_fichero, $pos_end_time, strlen($new_fichero));
//				}
				$more_ingredients = true;
				$ingredients = array();
				$pos_ingredients_list = strpos($new_fichero, "list-yellow");
				$new_fichero = substr($new_fichero, $pos_ingredients_list, strlen($new_fichero));
				while($more_ingredients){
					$pos_ingredient = strpos($new_fichero, "recipeIngredient");
					$new_fichero = substr($new_fichero, $pos_ingredient+16, strlen($new_fichero));
					$pos_end_ingredient = strpos($new_fichero, '</li');
					$ingredient = substr($new_fichero,0,$pos_end_ingredient);
					$new_fichero = substr($new_fichero, $pos_end_ingredient, strlen($new_fichero));
					$pos_ingredient = strpos($new_fichero, "recipeIngredient");
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
					$parecidos = false;
					$i = strtolower($i);
					$i = $this->elimina_acentos($i);
					foreach($ingredientsDB as $ingredientDB){
						if(strpos(" ".$i, $ingredientDB->search)){
							$parecidos = true;
						}
					}
					if(!$parecidos){
						try{
							$ingredient = new \Ingredients\Ingredients();
							$ingredient->name = $i;
							$ingredient->search = $i;
							$ingredient->save();
						}catch (Exception $e){

						}
					}
				}



			}
			echo $new_fichero;
		}

	}

	public function getDerivedIngredients()
	{
		$ingredientsDB = DB::table('ingredients')
			->whereNull('ingredients_id')
			->get();
		$index_parecidos = 0;
		$index_no_parecidos = 0;
		for($n = 21; $n<=40; $n++){
			if($n%4==0){
				$a = "";
			}
			$url_busqueda = "http://canalcocina.es/recetas/buscar/pag/".$n."/";
			$new_fichero = file_get_contents($url_busqueda);
			$more_recipes = true;
			$urls = array();
			while($more_recipes){
				$pos = strpos($new_fichero, "ribbon");
				$new_fichero = substr($new_fichero, $pos, strlen($new_fichero));

				$pos_href = strpos($new_fichero, "href");
				$new_fichero = substr($new_fichero, $pos_href+6, strlen($new_fichero));
				$pos_end_href = strpos($new_fichero, '"');
				$url = "http://canalcocina.es/".substr($new_fichero,0,$pos_end_href);
				if(strpos($url,"video") == false){
					$new_fichero = substr($new_fichero, $pos_end_href+6, strlen($new_fichero));

					$pos_img = strpos($new_fichero, "src");
					$new_fichero = substr($new_fichero, $pos_img+5, strlen($new_fichero));
					$pos_end_img = strpos($new_fichero, '"');
					$foto = substr($new_fichero,0,$pos_end_img);
					$new_fichero = substr($new_fichero, $pos_end_img, strlen($new_fichero));

//					$pos_title = strpos($new_fichero, "title");
//					$new_fichero = substr($new_fichero, $pos_title+26, strlen($new_fichero));
//					$pos_end_title = strpos($new_fichero, '<');
//					$title = substr($new_fichero,0,$pos_end_title);
//					$new_fichero = substr($new_fichero, $pos_end_title, strlen($new_fichero));

					array_push($urls, array('url' => $url, "image_url" => $foto,
//						"title" => $title
					));

					$pos = strpos($new_fichero, "recipe");
					if(!$pos){
						$more_recipes = false;
					}
				}
			}
			foreach($urls as $url){
				$new_fichero = file_get_contents($url['url']);
//				$pos_time = strpos($new_fichero, 'pattern="\d*">');
//				if($pos_time == false){
//					$time = 0;
//				}else{
//					$new_fichero = substr($new_fichero, $pos_time+6, strlen($new_fichero));
//					$pos_end_time = strpos($new_fichero, ' minutos');
//					$time = "https://cookpad.com".substr($new_fichero,0,$pos_end_time);
//					$new_fichero = substr($new_fichero, $pos_end_time, strlen($new_fichero));
//				}
				$more_ingredients = true;
				$ingredients = array();
				$pos_ingredients_list = strpos($new_fichero, "list-yellow");
				$new_fichero = substr($new_fichero, $pos_ingredients_list, strlen($new_fichero));
				while($more_ingredients){
					$pos_ingredient = strpos($new_fichero, "recipeIngredient");
					$new_fichero = substr($new_fichero, $pos_ingredient+16, strlen($new_fichero));
					$pos_end_ingredient = strpos($new_fichero, '</li');
					$ingredient = substr($new_fichero,0,$pos_end_ingredient);
					$new_fichero = substr($new_fichero, $pos_end_ingredient, strlen($new_fichero));
					$pos_ingredient = strpos($new_fichero, "recipeIngredient");
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
								$si_name = $this->elimina_acentos($si->search);
								if(strpos(" ".$i, $si_name)){
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

	public function getRecipes()
	{
		$ingredientsDB = DB::table('ingredients')
			->whereNull('ingredients_id')
			->get();
		$subIngredientsDB = DB::table('ingredients')
			->whereNotNull('ingredients_id')
			->get();
		//en el futuro hasta 81.
		for($n =1; $n<=1; $n++){
			if($n%4==0){
				$a = "";
			}
			$url_busqueda = "http://canalcocina.es/recetas/buscar/pag/".$n."/";
			$new_fichero = file_get_contents($url_busqueda);
			$more_recipes = true;
			$urls = array();
			while($more_recipes){
				$pos = strpos($new_fichero, "ribbon");
				$new_fichero = substr($new_fichero, $pos, strlen($new_fichero));

				$pos_href = strpos($new_fichero, "href");
				$new_fichero = substr($new_fichero, $pos_href+6, strlen($new_fichero));
				$pos_end_href = strpos($new_fichero, '"');
				$url = "http://canalcocina.es/".substr($new_fichero,0,$pos_end_href);
				if(strpos($url,"video") == false){
					$new_fichero = substr($new_fichero, $pos_end_href+6, strlen($new_fichero));

					$pos_img = strpos($new_fichero, "src");
					$new_fichero = substr($new_fichero, $pos_img+5, strlen($new_fichero));
					$pos_end_img = strpos($new_fichero, '"');
					$foto = substr($new_fichero,0,$pos_end_img);
					$new_fichero = substr($new_fichero, $pos_end_img, strlen($new_fichero));

					$pos_title = strpos($new_fichero, "</i>");
					$new_fichero = substr($new_fichero, $pos_title+4, strlen($new_fichero));
					$pos_end_title = strpos($new_fichero, '</span>');
					$title = substr($new_fichero,0,$pos_end_title);
					$new_fichero = substr($new_fichero, $pos_end_title, strlen($new_fichero));

					array_push($urls, array('url' => $url, "image_url" => $foto,
						"title" => $title
					));

					$pos = strpos($new_fichero, "recipe");
					if(!$pos){
						$more_recipes = false;
					}
				}
			}
			foreach($urls as $url){
				$new_fichero = file_get_contents($url['url']);
				$num_ingredients = 0;
				$pos_time = strpos($new_fichero, 'Tiempo');
				if($pos_time == false){
					$time = 0;
				}else{
					$new_fichero = substr($new_fichero, $pos_time+8, strlen($new_fichero));
					$time = "https://cookpad.com".substr($new_fichero,0,7);
					$new_fichero = substr($new_fichero, 7, strlen($new_fichero));
				}
				$more_ingredients = true;
				$ingredients = array();
				$pos_ingredients_list = strpos($new_fichero, "list-yellow");
				$new_fichero = substr($new_fichero, $pos_ingredients_list, strlen($new_fichero));
				while($more_ingredients){
					$pos_ingredient = strpos($new_fichero, "recipeIngredient");
					$new_fichero = substr($new_fichero, $pos_ingredient+16, strlen($new_fichero));
					$pos_end_ingredient = strpos($new_fichero, '</li');
					$ingredient = substr($new_fichero,0,$pos_end_ingredient);
					$new_fichero = substr($new_fichero, $pos_end_ingredient, strlen($new_fichero));
					$pos_ingredient = strpos($new_fichero, "recipeIngredient");
					array_push($ingredients, $ingredient);
					if(!$pos_ingredient){
						$more_ingredients = false;
					}
				}
				$recipe = new \Recipes\Recipes();
				$recipe->name = $url['title'];
				$recipe->url = $url['url'];
				$recipe->time = $time;
				$recipe->image_url = $foto;
				$recipe->description = "".$n;
				$recipe->save();

				foreach($ingredients as $i){
					$i = strtolower($i);
					$i = $this->elimina_acentos($i);
					$exist_ingredient = false;
					$ingredients_parecidos = array();
					foreach($ingredientsDB as $ingredientDB){
						$op = explode(",", $ingredientDB->search);
						foreach($op as $o){
							if(strpos(" ".$i,$o) != false) {
								array_push($ingredients_parecidos, $ingredientDB);
							}
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
							$op = explode(",", $si->search);
							foreach($op as $o){
								if(strpos(" ".$i,$o) != false) {
									try{
										$recipe->ingredients()->attach($si->id);
										$recipe->save();
										$num_ingredients++;
										$exist_sub_ingredient = true;
										break;
									}catch (Exception $e){

									}
								}
							}
						}
						if(!$exist_sub_ingredient){
							try{
								$recipe->ingredients()->attach($ingredients_parecidos[$index]->id);
								$recipe->save();
								$num_ingredients++;
							}catch (Exception $e){
							}

						}
					}else{
						foreach($subIngredientsDB as $si){
							$op = explode(",", $si->search);
							foreach($op as $o) {
								if (strpos(" " . $i, $o) != false) {
									try {
										$recipe->ingredients()->attach($si->id);
										$recipe->save();
										$num_ingredients++;
										break;
									} catch (Exception $e) {
									}
								}
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
	public function reviseRecipes(){
		$recipes = DB::table('recipes')->where('time',"==",0)->where('num_ingredients',"<",4)->get();
		$ingredientsDB = DB::table('ingredients')
			->whereNull('ingredients_id')
			->get();
		$subIngredientsDB = DB::table('ingredients')
			->whereNotNull('ingredients_id')
			->get();
		foreach($recipes as $recipe){
			$num_ingredients = 0;
			$new_fichero = file_get_contents($recipe->url);
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
			$recipe = \Recipes\Recipes::find($recipe->id);

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
							$num_ingredients++;
							try{
								$recipe->ingredients()->attach($si->id);
								$recipe->save();
							}catch (Exception $e){

							}
							break;
						}
					}
					if(!$exist_sub_ingredient){
						$num_ingredients++;
						try{
							$recipe->ingredients()->attach($ingredients_parecidos[$index]->id);
							$recipe->save();
						}catch(Exception $e){

						}

					}
				}else{
					foreach($subIngredientsDB as $si){
						if(strpos(" ".$i, $si->search)){
							$num_ingredients++;
							try{
								$recipe->ingredients()->attach($si->id);
								$recipe->save();
							}catch (Exception $e){

							}
							break;
						}
					}
				}
			}
			$recipe->num_ingredients = $num_ingredients;
			$recipe->save();
		}
		echo "TERMINADO";
	}
}
