<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024.
 */

use App\Models\Quiz;
use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;
use Mary\Traits\Toast;
use App\Traits\ManageQuiz;
use Illuminate\Support\Collection;

new #[Title('Edit Quiz'), Layout('components.layouts.admin')] class extends Component {
	use Toast, ManageQuiz;

    public Quiz $quiz;
    public string $title = '';
    public string $description = '';
    public array $questions = [];
    public ?int $post_id = null;
    public Collection $postsSearchable;

    public function mount(Quiz $quiz): void
    {
		if (Auth()->user()->isRedac() && $quiz->user_id !== Auth()->id()) {
			abort(403);
		}

        $this->quiz = $quiz;
        $this->quiz->load('questions.answers', 'post:id,title');
        $this->post_id = $this->quiz->post_id;
        $this->title = $quiz->title;
        $this->description = $quiz->description;

        foreach ($this->quiz->questions as $question) {
            $this->questions[] = [
                'question_text' => $question->question_text,
                'answers' => $question->answers->map(function ($answer) {
                    return [
                        'answer_text' => $answer->answer_text,
                        'is_correct' => (bool)$answer->is_correct,
                    ];
                })->toArray(),
            ];
        }

        $this->search();
    }

    public function save()
    {
        $data = $this->validate($this->rules);

        $this->quiz->update($data);

        // Synchroniser les questions et les réponses
        foreach ($data['questions'] as $qIndex => $question) {
            $quizQuestion = $this->quiz->questions()->updateOrCreate(
                ['id' => $this->quiz->questions[$qIndex]->id ?? null],
                ['question_text' => $question['question_text']]
            );

            foreach ($question['answers'] as $aIndex => $answer) {
                $quizQuestion->answers()->updateOrCreate(
                    ['id' => $quizQuestion->answers[$aIndex]->id ?? null],
                    ['answer_text' => $answer['answer_text'], 'is_correct' => $answer['is_correct']]
                );
            }
        }

        $this->success(__('Quiz edited with success.'), redirectTo: '/admin/quizzes/index');
    }
   
}; ?>

<div>
    <x-card>
        <x-header title="{{ __('Edit a Quiz') }}" shadow separator progress-indicator />
        <x-form wire:submit.prevent="save">
            <x-input type="text" wire:model="title" label="{{ __('Title') }}" placeholder="{{ __('Enter the title') }}" />
            <x-input type="text" wire:model="description" label="{{ __('Description') }}" placeholder="{{ __('Enter the description') }}" />
            <x-choices
                label="{{__('Post')}}"
                wire:model="post_id"
                :options="$postsSearchable"
                option-label="title"
                hint="{{__('Select a post or none, type to search')}}"
                debounce="300ms"
                min-chars="2"
                no-result-text="{{__('No result found!')}}"
                single
                searchable />
            @foreach ($questions as $qIndex => $question)
                <hr>
                <div class="flex flex-row justify-between">
                    <x-badge value="Question {{ $qIndex + 1 }}" class="p-4 badge-accent" />
                    @if($qIndex > 1)
                        <x-button label="{{ __('Remove Question') }}" wire:click.prevent="removeQuestion({{ $qIndex }})" class="btn-warning" />
                    @endif
                </div>
                <x-input type="text" wire:model="questions.{{ $qIndex }}.question_text" label="{{ __('Question') }}" placeholder="{{ __('Enter the question text') }}" /><hr>

                @foreach ($question['answers'] as $aIndex => $answer)
                    <x-input type="text" wire:model="questions.{{ $qIndex }}.answers.{{ $aIndex }}.answer_text" label="{{ __('Answer ') }} {{ $aIndex + 1 }}" placeholder="{{ __('Enter the answer text') }}" />
                    <x-checkbox wire:model="questions.{{ $qIndex }}.answers.{{ $aIndex }}.is_correct" label="{{ __('Is Correct') }}" />
                    @if($aIndex > 1)
                        <x-button label="{{ __('Remove Answer') }} {{ $aIndex + 1 }}" wire:click.prevent="removeAnswer({{ $qIndex }}, {{ $aIndex }})" class="btn-warning" />
                    @else
                        <hr>
                    @endif
                @endforeach

                <x-button label="{{ __('Add Answer') }}" wire:click.prevent="addAnswer({{ $qIndex }})" class="btn-primary" />

            @endforeach

            <x-button label="{{ __('Add Question') }}" wire:click.prevent="addQuestion" class="btn-info" />

            <x-slot:actions>
                <x-button label="{{ __('Save') }}" icon="o-paper-airplane" spinner="save" type="submit"
                    class="btn-primary" />
            </x-slot:actions>
        </x-form>
    </x-card>
</div>
