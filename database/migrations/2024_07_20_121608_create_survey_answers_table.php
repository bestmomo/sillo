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
		Schema::create('survey_answers', function (Blueprint $table)
		{
			$table->id();
			$table->foreignId('question_id')->constrained(table: 'survey_questions', indexName: 'id')->onDelete('cascade');
			$table->text('answer_text');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('survey_answers');
	}
};
