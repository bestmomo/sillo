<?php

namespace App\Traits;
use App\Models\Survey;

trait ManageSurvey
{
    public string $title = '';
    public string $description = '';
    public bool $active = false;
    public array $questions = [];

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'active' => 'required',
        'questions.*.question_text' => 'required|string|max:255',
        'questions.*.answers.*.answer_text' => 'required|string|max:255',
    ];

    /**
     * Adds a new question with default empty text and answers to the survey.
     *
     * @param int $number The number of questions to add. Default is 1.
     * @return void
     */
    public function addQuestion(int $number = 1): void
    {
        while($number--) {
            $this->questions[] = [
                'question_text' => '',
                'answers' => [
                    ['answer_text' => ''],
                    ['answer_text' => ''],
                    ['answer_text' => ''],
                ],
            ];
        }
    }

    /**
     * Removes a question from the survey by its index.
     *
     * @param int $index The index of the question to be removed.
     * @return void
     */
    public function removeQuestion($index): void
    {
        unset($this->questions[$index]);
        $this->questions = array_values($this->questions);
    }
    
    /**
     * Adds a new answer with default empty text ato a question.
     *
     * @param int $index The index of the question to add the answer to.
     * @return void
     */
    public function addAnswer($index): void
    {
        $this->questions[$index]['answers'][] = ['answer_text' => ''];
    }

    /**
     * Removes an answer from the survey by question and answer index.
     *
     * @param int $qIndex The index of the question.
     * @param int $aIndex The index of the answer in the question.
     * @return void
     */
    public function removeAnswer($qIndex, $aIndex): void
    {
        unset($this->questions[$qIndex]['answers'][$aIndex]);
        $this->questions[$qIndex]['answers'] = array_values($this->questions[$qIndex]['answers']);
    }

    /**
     * A method to define custom error messages for validation errors.
     *
     * @return array Custom error messages for specific validation rules.
     */
    protected function messages(): array
    {
        return [
            'questions.*.question_text.required' => __('The question text is required.'),
            'questions.*.answers.*.answer_text.required' => __('The answer text is required.'),
        ];
    }
}
