<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024.
 */

use App\Models\Survey;
use App\Traits\ManageSurvey;
use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new #[Title('Create Quiz'), Layout('components.layouts.admin')] class extends Component {
	use Toast;
	use ManageSurvey;

	public function mount(): void
	{
		$this->addQuestion(2);
	}

	public function save()
	{
		$data = $this->validate($this->rules);

		$survey = Survey::create(
			$data + [
				'user_id' => Auth::id(),
			],
		);

		foreach ($data['questions'] as $question) {
			$surveyQuestion = $survey->questions()->create([
				'question_text' => $question['question_text'],
			]);

			foreach ($question['answers'] as $answer) {
				$surveyQuestion->answers()->create($answer);
			}
		}

		$this->success(__('Survey added with success.'), redirectTo: '/admin/surveys/index');
	}
}; ?>

<div>
    <x-header title="{{ __('Create a Survey') }}" separator progress-indicator>
        <x-slot:actions class="lg:hidden">
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline"
                link="{{ route('admin') }}" />
        </x-slot:actions>
    </x-header>
    @include('livewire.admin.surveys.survey-form')    
</div>
