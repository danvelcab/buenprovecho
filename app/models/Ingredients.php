<?php

namespace Ingredients;

use Illuminate\Database\Eloquent\Model;

class Ingredients extends Model {

	protected $table = 'ingredients';
	public $timestamps = true;

	public function configurations()
	{
		return $this->belongsToMany('Configurations');
	}

	public function recipes()
	{
		return $this->belongsToMany('Recipes');
	}

	public function ingredients()
	{
		return $this->hasMany('Ingredients');
	}

}