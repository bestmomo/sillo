<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

namespace Database\Seeders\Main;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\{Survey, SurveyAnswer, SurveyQuestion};
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SurveySeeder extends Seeder
{
	use WithoutModelEvents;

	public function run()
	{
		// Sondages
		$survey1 = Survey::create([
			'title'       => 'Laravel',
			'description' => 'Testez vos pratiques sur Laravel.',
			'user_id'     => 1,
		]);

		$question1 = SurveyQuestion::create([
			'survey_id'     => $survey1->id,
			'question_text' => 'Comment appréciez-vous Laravel ?',
		]);

		SurveyAnswer::create([
			'question_id' => $question1->id,
			'answer_text' => 'Pas du tout',
		]);

		SurveyAnswer::create([
			'question_id' => $question1->id,
			'answer_text' => 'Moyennement',
		]);

		SurveyAnswer::create([
			'question_id' => $question1->id,
			'answer_text' => 'Plutôt bien',
		]);

		SurveyAnswer::create([
			'question_id' => $question1->id,
			'answer_text' => 'J\'adore',
		]);

		$question2 = SurveyQuestion::create([
			'survey_id'     => $survey1->id,
			'question_text' => 'Combien de temps codez-vous tous les jours ?',
		]);

		SurveyAnswer::create([
			'question_id' => $question2->id,
			'answer_text' => 'moins de 10 minutes',
		]);

		SurveyAnswer::create([
			'question_id' => $question2->id,
			'answer_text' => 'une heure',
		]);

		SurveyAnswer::create([
			'question_id' => $question2->id,
			'answer_text' => 'plus de 2 heures',
		]);

		SurveyAnswer::create([
			'question_id' => $question2->id,
			'answer_text' => 'plus de 3 heures',
		]);

		DB::table('survey_user')->insert([
			['user_id' => '5', 'survey_id' => 1, 'answers' => '13', 'created_at' => now(), 'updated_at' => now()],
			['user_id' => '2', 'survey_id' => 1, 'answers' => '24', 'created_at' => now(), 'updated_at' => now()],
			['user_id' => '3', 'survey_id' => 1, 'answers' => '31', 'created_at' => now(), 'updated_at' => now()],
			['user_id' => '7', 'survey_id' => 1, 'answers' => '42', 'created_at' => now(), 'updated_at' => now()],
			['user_id' => '6', 'survey_id' => 1, 'answers' => '22', 'created_at' => now(), 'updated_at' => now()],
			['user_id' => '3', 'survey_id' => 1, 'answers' => '33', 'created_at' => now(), 'updated_at' => now()],
		]);
	}
}
