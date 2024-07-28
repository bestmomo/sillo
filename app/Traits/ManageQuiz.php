<?php

namespace App\Traits;
use App\Models\Post;

trait ManageQuiz
{
    public string $title = '';
    public string $description = '';
    public array $questions = [];

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'post_id' => 'nullable|integer|exists:posts,id',
        'questions.*.question_text' => 'required|string|max:255',
        'questions.*.answers.*.answer_text' => 'required|string|max:255',
        'questions.*.answers.*.is_correct' => 'required|boolean',
    ];

    /**
     * Search for posts based on the provided value.
     *
     * @param string $value The value to search for within post titles.
     * @return void
     */
    public function search(string $value = ''): void
    {
        $selectedOption = Post::select('id', 'title')->where('id', $this->post_id)->get();

        $this->postsSearchable = Post::query()
            ->select('id', 'title')
            ->doesntHave('quiz')
            ->where('title', 'like', "%$value%")            
            ->select('id', 'title')
            ->orderBy('title')
            ->take(5)
            ->get()
            ->merge($selectedOption);
    }

    /**
     * Adds a new question with default empty text and answers to the quiz.
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
                    ['answer_text' => '', 'is_correct' => false],
                    ['answer_text' => '', 'is_correct' => false],
                    ['answer_text' => '', 'is_correct' => false],
                ],
            ];
        }
    }

    /**
     * Removes a question from the quiz by its index.
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
     * Adds a new answer with default empty text and correct status to a question.
     *
     * @param int $index The index of the question to add the answer to.
     * @return void
     */
    public function addAnswer($index): void
    {
        $this->questions[$index]['answers'][] = ['answer_text' => '', 'is_correct' => false];
    }

    /**
     * Removes an answer from the quiz by question and answer index.
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
