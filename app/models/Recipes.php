<?php

namespace Recipes;

use Illuminate\Database\Eloquent\Model;

class Recipes extends Model {

	protected $table = 'recipes';
	public $timestamps = true;

	public function ingredients()
	{
		return $this->belongsToMany('Ingredients\Ingredients');
	}

	public function actor()
	{
		return $this->belongsTo('Actors');
	}

}