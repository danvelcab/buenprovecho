<?php

namespace Configurations;

use Illuminate\Database\Eloquent\Model;

class Configurations extends Model {

	protected $table = 'configurations';
	public $timestamps = true;

	public function actor()
	{
		return $this->belongsTo('Actors');
	}

	public function ingredientes_dislike()
	{
		return $this->belongsToMany('Ingredients');
	}

}