<?php

class BlogController extends BaseController {

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

	public function listPosts()
	{
		$posts = Posts\Posts::all();
		return View::make('posts.list', array ('posts' => $posts));
	}
	public function show($id){
		$post = \Posts\Posts::find($id);
		return View::make('posts.show', array('post' => $post));
	}

}
