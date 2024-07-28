<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024.
 */

use App\Models\Survey;
use App\Traits\ManageSurvey;
use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;
use Mary\Traits\Toast;
use Illuminate\Support\Collection;

new #[Title('Create Quiz'), Layout('components.layouts.admin')] class extends Component {
    use Toast, ManageSurvey;

    public Survey $survey;

    public function mount(Survey $survey): void
    {
        if (Auth()->user()->isRedac() && $survey->user_id !== Auth()->id()) {
            abort(403);
        }

        $this->survey = $survey;
        $this->survey->load('questions.answers');
        $this->title = $survey->title;
        $this->description = $survey->description;
        $this->active = $survey->active;

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

}; ?>

<div>
    <x-header title="{{ __('Edit a Survey') }}" separator progress-indicator>
        <x-slot:actions class="lg:hidden">
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline"
                link="{{ route('admin') }}" />
        </x-slot:actions>
    </x-header>
    @include('livewire.admin.surveys.survey-form')    
</div>
