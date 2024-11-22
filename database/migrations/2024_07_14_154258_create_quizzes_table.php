<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Schema::create('quizzes', function (Blueprint $table) {
			$table->id();
			$table->string('title');
			$table->text('description')->nullable();
			$table->timestamps();
			$table->unsignedBigInteger('post_id')->nullable();

			$table->foreignId('user_id')
				->constrained()
				->onDelete('cascade')
				->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::dropIfExists('quizzes');
	}
};
