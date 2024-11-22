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
		Schema::create('quiz_user', function (Blueprint $table) {
			$table->id();
			$table->foreignId('quiz_id')->constrained()->onDelete('cascade'); // Relation avec les quizzes
			$table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relation avec les utilisateurs
			$table->integer('correct_answers'); // Nombre de réponses correctes
			$table->integer('total_answers'); // Nombre total de réponses attendues
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::dropIfExists('quiz_user');
	}
};
