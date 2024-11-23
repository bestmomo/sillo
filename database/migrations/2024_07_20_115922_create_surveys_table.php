<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('surveys', function (Blueprint $table)
		{
			$table->id();
			$table->string('title');
			$table->text('description')->nullable();
			$table->boolean('active')->default(false);
			$table->timestamps();

			$table->foreignId('user_id')
				->constrained()
				->onDelete('cascade')
				->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('surveys');
	}
};
