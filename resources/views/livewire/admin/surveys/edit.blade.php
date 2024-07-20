<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024.
 */

use App\Models\Survey;
use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;
use Mary\Traits\Toast;
use Illuminate\Support\Collection;

new #[Title('Create Quiz'), Layout('components.layouts.admin')] class extends Component {
    use Toast;

    public Survey $survey;
    public string $title = '';
    public string $description = '';
    public array $questions = [];

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'questions.*.question_text' => 'required|string|max:255',
        'questions.*.answers.*.answer_text' => 'required|string|max:255',
    ];

    public function mount(Survey $survey): void
    {
        if (Auth()->user()->isRedac() && $survey->user_id !== Auth()->id()) {
            abort(403);
        }

        $this->survey = $survey;
        $this->survey->load('questions.answers');
        $this->title = $survey->title;
        $this->description = $survey->description;

        foreach ($this->survey->questions as $question) {
            $this->questions[] = [
                'question_text' => $question->question_text,
                'answers' => $question->answers
                    ->map(function ($answer) {
                        return [
                            'answer_text' => $answer->answer_text,
                        ];
                    })
                    ->toArray(),
            ];
        }
    }

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
                    ['answer_text' => '', 'is_correct' => false],
                    ['answer_text' => '', 'is_correct' => false],
                    ['answer_text' => '', 'is_correct' => false],
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

    public function save()
    {
        $data = $this->validate($this->rules);

        $this->survey->update($data);

        // Synchroniser les questions et les réponses
        foreach ($data['questions'] as $qIndex => $question) {
            $surveyQuestion = $this->survey->questions()->updateOrCreate(['id' => $this->survey->questions[$qIndex]->id ?? null], ['question_text' => $question['question_text']]);

            foreach ($question['answers'] as $aIndex => $answer) {
                $surveyQuestion->answers()->updateOrCreate(['id' => $surveyQuestion->answers[$aIndex]->id ?? null], ['answer_text' => $answer['answer_text']]);
            }
        }

        $this->success(__('Survey edited with success.'), redirectTo: '/admin/surveys/index');
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

}; ?>

<div>
    <x-header title="{{ __('Edit a Survey') }}" separator progress-indicator>
        <x-slot:actions class="lg:hidden">
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline"
                link="{{ route('admin') }}" />
        </x-slot:actions>
    </x-header>
    <x-card>
        <x-form wire:submit.prevent="save">
            <x-input type="text" wire:model="title" label="{{ __('Title') }}"
                placeholder="{{ __('Enter the title') }}" />
            <x-input type="text" wire:model="description" label="{{ __('Description') }}"
                placeholder="{{ __('Enter the description') }}" />
            @foreach ($questions as $qIndex => $question)
                <hr>
                <div class="flex flex-row justify-between">
                    <x-badge value="Question {{ $qIndex + 1 }}" class="p-4 badge-accent" />
                    @if ($qIndex > 1)
                        <x-button label="{{ __('Remove Question') }}"
                            wire:click.prevent="removeQuestion({{ $qIndex }})" class="btn-warning" />
                    @endif
                </div>
                <x-input type="text" wire:model="questions.{{ $qIndex }}.question_text"
                    label="{{ __('Question') }}" placeholder="{{ __('Enter the question text') }}" />
                <hr>
    
                @foreach ($question['answers'] as $aIndex => $answer)
                    <x-input type="text"
                        wire:model="questions.{{ $qIndex }}.answers.{{ $aIndex }}.answer_text"
                        label="{{ __('Answer ') }} {{ $aIndex + 1 }}"
                        placeholder="{{ __('Enter the answer text') }}" />
                    @if ($aIndex > 1)
                        <x-button label="{{ __('Remove Answer') }} {{ $aIndex + 1 }}"
                            wire:click.prevent="removeAnswer({{ $qIndex }}, {{ $aIndex }})"
                            class="btn-warning" />
                    @else
                        <hr>
                    @endif
                @endforeach
    
                <x-button label="{{ __('Add Answer') }}" wire:click.prevent="addAnswer({{ $qIndex }})"
                    class="btn-primary" />
            @endforeach
    
            <x-button label="{{ __('Add Question') }}" wire:click.prevent="addQuestion" class="btn-info" />
    
            <x-slot:actions>
                <x-button label="{{ __('Save') }}" icon="o-paper-airplane" spinner="save" type="submit"
                    class="btn-primary" />
            </x-slot:actions>
        </x-form>
    </x-card>
    
    
</div>
