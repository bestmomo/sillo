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
		Schema::create('events', function (Blueprint $table)
		{
			$table->id();
			$table->string('label');
			$table->text('description');
			$table->enum('color', ['red', 'orange', 'amber', 'yellow', 'lime', 'green', 'emerald', 'teal', 'cyan', 'sky', 'blue', 'indigo', 'violet', 'purple', 'fuchsia', 'pink', 'rose']);
			$table->dateTime('start_date');
			$table->dateTime('end_date')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('events');
	}
};
