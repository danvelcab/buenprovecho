<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngredientsConfigurationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ingredient_configurations', function(Blueprint $table)
		{
            $table->increments('id');
            $table->integer('ingredients_id')->unsigned()->index()->nullable();
            $table->integer('configurations_id')->unsigned()->index()->nullable();
            $table->timestamps();
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('ingredients_configurations');
	}

}
