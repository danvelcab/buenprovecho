<?php

namespace Actors;

use Illuminate\Database\Eloquent\Model;

class Actors extends Model {

	protected $table = 'actors';
	public $timestamps = true;

	public function configuration()
	{
		return $this->hasOne('Configurations');
	}

	public function recipes()
	{
		return $this->hasMany('Recipes');
	}

}