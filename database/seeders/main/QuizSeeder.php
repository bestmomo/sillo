<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */


/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

namespace database\seeders\main;


use App\Models\{Answer, Question, Quiz};
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
	use WithoutModelEvents;

	public function run()
	{
		// Sondages

		// Création du premier quiz avec ses questions et réponses
		$quiz1 = Quiz::create([
			'title'       => 'Laravel',
			'description' => 'Testez vos connaissances sur Laravel.',
			'user_id'     => 1,
			'post_id'     => 5,
		]);

		$question1 = Question::create([
			'quiz_id'       => $quiz1->id,
			'question_text' => 'Quel est le nom du créateur de Laravel ?',
		]);

		Answer::create([
			'question_id' => $question1->id,
			'answer_text' => 'Taylor Otwell',
			'is_correct'  => true,
		]);

		Answer::create([
			'question_id' => $question1->id,
			'answer_text' => 'Jeffrey Way',
			'is_correct'  => false,
		]);

		Answer::create([
			'question_id' => $question1->id,
			'answer_text' => 'Jesus Christ',
			'is_correct'  => false,
		]);

		$question2 = Question::create([
			'quiz_id'       => $quiz1->id,
			'question_text' => 'Quelle est la dernière version stable de Laravel ?',
		]);

		Answer::create([
			'question_id' => $question2->id,
			'answer_text' => '11.x',
			'is_correct'  => true,
		]);

		Answer::create([
			'question_id' => $question2->id,
			'answer_text' => '10.x',
			'is_correct'  => false,
		]);

		Answer::create([
			'question_id' => $question2->id,
			'answer_text' => '9.x',
			'is_correct'  => false,
		]);

		// Création du deuxième quiz avec ses questions et réponses
		$quiz2 = Quiz::create([
			'title'       => 'PHP',
			'description' => 'Testez vos connaissances sur PHP.',
			'user_id'     => 2,
		]);

		$question3 = Question::create([
			'quiz_id'       => $quiz2->id,
			'question_text' => 'Quel est l\'acronyme de PHP ?',
		]);

		Answer::create([
			'question_id' => $question3->id,
			'answer_text' => 'Hypertext Preprocessor',
			'is_correct'  => true,
		]);

		Answer::create([
			'question_id' => $question3->id,
			'answer_text' => 'Personal Home Page',
			'is_correct'  => false,
		]);

		$question4 = Question::create([
			'quiz_id'       => $quiz2->id,
			'question_text' => 'Quel est le fondateur de PHP ?',
		]);

		Answer::create([
			'question_id' => $question4->id,
			'answer_text' => 'Rasmus Lerdorf',
			'is_correct'  => true,
		]);

		Answer::create([
			'question_id' => $question4->id,
			'answer_text' => 'Taylor Otwell',
			'is_correct'  => false,
		]);
	}
}
