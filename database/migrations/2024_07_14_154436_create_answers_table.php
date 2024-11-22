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
		Schema::create('answers', function (Blueprint $table) {
			$table->id();
			$table->foreignId('question_id')->constrained()->onDelete('cascade');
			$table->text('answer_text');
			$table->boolean('is_correct')->default(false);
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::dropIfExists('answers');
	}
};
