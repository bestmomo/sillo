<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pages', function (Blueprint $table) {
			$table->id();
			$table->string('slug');
			$table->string('title');
			$table->text('body');
			$table->string('seo_title');
			$table->text('meta_description');
			$table->text('meta_keywords');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('pages');
	}
}
