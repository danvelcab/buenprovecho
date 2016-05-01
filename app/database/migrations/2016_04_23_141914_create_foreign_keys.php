<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('actors', function(Blueprint $table) {
			$table->foreign('configuration_id')->references('id')->on('configurations')
						->onDelete('restrict')
						->onUpdate('no action');
		});
		Schema::table('ingredients', function(Blueprint $table) {
			$table->foreign('ingredients_id')->references('id')->on('ingredients')
						->onDelete('restrict')
						->onUpdate('cascade');
		});
		Schema::table('recipes', function(Blueprint $table) {
			$table->foreign('actor_id')->references('id')->on('actors')
						->onDelete('restrict')
						->onUpdate('no action');
		});
	}

	public function down()
	{
		Schema::table('actors', function(Blueprint $table) {
			$table->dropForeign('actors_configuration_id_foreign');
		});
		Schema::table('ingredients', function(Blueprint $table) {
			$table->dropForeign('ingredients_ingredients_id_foreign');
		});
		Schema::table('recipes', function(Blueprint $table) {
			$table->dropForeign('recipes_actor_id_foreign');
		});
	}
}