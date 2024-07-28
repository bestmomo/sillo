<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

namespace database\seeders\main;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\{Survey, SurveyAnswer, SurveyQuestion};
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SurveySeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {
        // Données des sondages
        $surveys = [
            [
                'title'       => 'Laravel',
                'description' => 'Testez vos pratiques sur Laravel.',
                'user_id'     => 1,
                'questions'   => [
                    [
                        'question_text' => 'Comment appréciez-vous Laravel ?',
                        'answers'       => [
                            ['answer_text' => 'Pas du tout'],
                            ['answer_text' => 'Moyennement'],
                            ['answer_text' => 'Plutôt bien'],
                            ['answer_text' => 'J\'adore'],
                        ],
                    ],
                    [
                        'question_text' => 'Combien de temps codez-vous tous les jours ?',
                        'answers'       => [
                            ['answer_text' => 'moins de 10 minutes'],
                            ['answer_text' => 'une heure'],
                            ['answer_text' => 'plus de 2 heures'],
                            ['answer_text' => 'plus de 3 heures'],
                        ],
                    ],
                ],
            ],
        ];

        // Données des utilisateurs ayant répondu aux sondages
        $surveyUsers = [
            ['user_id' => 5, 'survey_id' => 1, 'answers' => '13', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 2, 'survey_id' => 1, 'answers' => '24', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 3, 'survey_id' => 1, 'answers' => '31', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 7, 'survey_id' => 1, 'answers' => '42', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 6, 'survey_id' => 1, 'answers' => '22', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 3, 'survey_id' => 1, 'answers' => '33', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($surveys as $surveyData) {
            // Créer le sondage
            $survey = Survey::create([
                'title'       => $surveyData['title'],
                'description' => $surveyData['description'],
                'user_id'     => $surveyData['user_id'],
            ]);

            // Créer les questions et les réponses associées
            foreach ($surveyData['questions'] as $questionData) {
                $question = SurveyQuestion::create([
                    'survey_id'     => $survey->id,
                    'question_text' => $questionData['question_text'],
                ]);
                foreach ($questionData['answers'] as $answerData) {
                    SurveyAnswer::create([
                        'question_id' => $question->id,
                        'answer_text' => $answerData['answer_text'],
                    ]);
                }
            }
        }

        // Insérer les données des utilisateurs ayant répondu aux sondages
        DB::table('survey_user')->insert($surveyUsers);
    }
}
