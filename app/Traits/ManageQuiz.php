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

    public function search(string $value = ''): void
    {
        $selectedOption = Post::where('id', $this->post_id)->get();

        $this->postsSearchable = Post::query()
            ->where('title', 'like', "%$value%")
            ->select('id', 'title')
            ->orderBy('title')
            ->take(5)
            ->get()
            ->merge($selectedOption);
    }

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

    public function removeQuestion($index): void
    {
        unset($this->questions[$index]);
        $this->questions = array_values($this->questions);
    }

    public function addAnswer($index): void
    {
        $this->questions[$index]['answers'][] = ['answer_text' => '', 'is_correct' => false];
    }

    public function removeAnswer($qIndex, $aIndex): void
    {
        unset($this->questions[$qIndex]['answers'][$aIndex]);
        $this->questions[$qIndex]['answers'] = array_values($this->questions[$qIndex]['answers']);
    }

    protected function messages(): array
    {
        return [
            'questions.*.question_text.required' => __('The question text is required.'),
            'questions.*.answers.*.answer_text.required' => __('The answer text is required.'),
        ];
    }
}
