<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024.
 */

use App\Models\Quiz;
use App\Traits\ManageQuiz;
use Illuminate\Support\Collection;
use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new #[Title('Create Quiz'), Layout('components.layouts.admin')] class extends Component {
	use Toast;
	use ManageQuiz;

	public string $title       = '';
	public string $description = '';
	public array $questions    = [];
	public ?int $post_id       = null;
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
    @include('livewire.admin.quizzes.quiz-form')
</div>
