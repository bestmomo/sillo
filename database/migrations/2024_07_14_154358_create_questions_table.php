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
		Schema::create('questions', function (Blueprint $table) {
			$table->id();
			$table->foreignId('quiz_id')->constrained()->onDelete('cascade');
			$table->text('question_text');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::dropIfExists('questions');
	}
};
