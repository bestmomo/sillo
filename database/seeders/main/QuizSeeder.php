<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

namespace Database\Seeders\Main;

use App\Models\{Answer, Question, Quiz};
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder {
	use WithoutModelEvents;

	public function run() {
		// Données des quiz
		$quizzes = [
			[
				'title'       => 'Laravel',
				'description' => 'Testez vos connaissances sur Laravel.',
				'user_id'     => 1,
				'post_id'     => 5,
				'questions'   => [
					[
						'question_text' => 'Quel est le nom du créateur de Laravel ?',
						'answers'       => [
							['answer_text' => 'Taylor Otwell', 'is_correct' => true],
							['answer_text' => 'Jeffrey Way', 'is_correct' => false],
							['answer_text' => 'Jesus Christ', 'is_correct' => false],
						],
					],
					[
						'question_text' => 'Quelle est la dernière version stable de Laravel ?',
						'answers'       => [
							['answer_text' => '11.x', 'is_correct' => true],
							['answer_text' => '10.x', 'is_correct' => false],
							['answer_text' => '9.x', 'is_correct' => false],
						],
					],
				],
			],
			[
				'title'       => 'PHP',
				'description' => 'Testez vos connaissances sur PHP.',
				'user_id'     => 2,
				'questions'   => [
					[
						'question_text' => 'Quel est l\'acronyme de PHP ?',
						'answers'       => [
							['answer_text' => 'Hypertext Preprocessor', 'is_correct' => true],
							['answer_text' => 'Personal Home Page', 'is_correct' => false],
						],
					],
					[
						'question_text' => 'Quel est le fondateur de PHP ?',
						'answers'       => [
							['answer_text' => 'Rasmus Lerdorf', 'is_correct' => true],
							['answer_text' => 'Taylor Otwell', 'is_correct' => false],
						],
					],
				],
			],
		];

		foreach ($quizzes as $quizData) {
			// Créer le quiz
			$quiz = Quiz::create([
				'title'       => $quizData['title'],
				'description' => $quizData['description'],
				'user_id'     => $quizData['user_id'],
				'post_id'     => $quizData['post_id'] ?? null,
			]);

			// Créer les questions et les réponses associées
			foreach ($quizData['questions'] as $questionData) {
				$question = Question::create([
					'quiz_id'       => $quiz->id,
					'question_text' => $questionData['question_text'],
				]);
				foreach ($questionData['answers'] as $answerData) {
					Answer::create([
						'question_id' => $question->id,
						'answer_text' => $answerData['answer_text'],
						'is_correct'  => $answerData['is_correct'],
					]);
				}
			}
		}
	}
}
