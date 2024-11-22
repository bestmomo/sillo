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

new #[Title('Edit Quiz'), Layout('components.layouts.admin')] class extends Component {
	use Toast;
	use ManageQuiz;

	public Quiz $quiz;
	public string $title       = '';
	public string $description = '';
	public array $questions    = [];
	public ?int $post_id       = null;
	public Collection $postsSearchable;

	public function mount(Quiz $quiz): void {
		if (Auth()->user()->isRedac() && $quiz->user_id !== Auth()->id()) {
			abort(403);
		}

		$this->quiz = $quiz;
		$this->quiz->load('questions.answers', 'post:id,title');
		$this->post_id     = $this->quiz->post_id;
		$this->title       = $quiz->title;
		$this->description = $quiz->description;

		foreach ($this->quiz->questions as $question) {
			$this->questions[] = [
				'question_text' => $question->question_text,
				'answers'       => $question->answers
					->map(function ($answer) {
						return [
							'answer_text' => $answer->answer_text,
							'is_correct'  => (bool) $answer->is_correct,
						];
					})
					->toArray(),
			];
		}

		$this->search();
	}

	public function save() {
		$data = $this->validate($this->rules);

		$this->quiz->update($data);

		// Synchroniser les questions et les réponses
		foreach ($data['questions'] as $qIndex => $question) {
			$quizQuestion = $this->quiz->questions()->updateOrCreate(['id' => $this->quiz->questions[$qIndex]->id ?? null], ['question_text' => $question['question_text']]);

			foreach ($question['answers'] as $aIndex => $answer) {
				$quizQuestion->answers()->updateOrCreate(['id' => $quizQuestion->answers[$aIndex]->id ?? null], ['answer_text' => $answer['answer_text'], 'is_correct' => $answer['is_correct']]);
			}
		}

		$this->success(__('Quiz edited with success.'), redirectTo: '/admin/quizzes/index');
	}
}; ?>

<div>
    <x-header title="{{ __('Edit a Quiz') }}" separator progress-indicator>
        <x-slot:actions class="lg:hidden">
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline"
                link="{{ route('admin') }}" />
        </x-slot:actions>
    </x-header>
    @include('livewire.admin.quizzes.quiz-form')
</div>
