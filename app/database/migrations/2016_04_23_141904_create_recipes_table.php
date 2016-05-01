<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRecipesTable extends Migration {

	public function up()
	{
		Schema::create('recipes', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->text('url');
			$table->integer('time');
			$table->text('image_url');
			$table->integer('actor_id')->unsigned()->nullable();
			$table->text('description');
		});
	}

	public function down()
	{
		Schema::drop('recipes');
	}
}