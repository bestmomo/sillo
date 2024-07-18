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

new #[Title('Create Quiz'), Layout('components.layouts.admin')] class extends Component {
    use Toast, ManageQuiz;

    public string $title = '';
    public string $description = '';
    public array $questions = [];
    public ?int $post_id = null;
    public Collection $postsSearchable;

    public function mount(): void
    {
        $this->addQuestion(2);
        $this->search();
    }

    public function save()
    {
        $data = $this->validate($this->rules);

        $quiz = Quiz::create(
            $data + [
                'user_id' => Auth::id(),
            ],
        );

        foreach ($data['questions'] as $question) {
            $quizQuestion = $quiz->questions()->create([
                'question_text' => $question['question_text'],
            ]);

            foreach ($question['answers'] as $answer) {
                $quizQuestion->answers()->create($answer);
            }
        }

        $this->success(__('Quiz added with success.'), redirectTo: '/admin/quizzes/index');
    }
}; ?>

<div>
    <x-header title="{{ __('Create a Quiz') }}" separator progress-indicator>
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
            <x-choices label="{{ __('Post') }}" wire:model="post_id" :options="$postsSearchable" option-label="title"
                hint="{{ __('Select a post or none, type to search') }}" debounce="300ms" min-chars="2"
                no-result-text="{{ __('No result found!') }}" single searchable />
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
                    <x-checkbox wire:model="questions.{{ $qIndex }}.answers.{{ $aIndex }}.is_correct"
                        label="{{ __('Is Correct') }}" />
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
