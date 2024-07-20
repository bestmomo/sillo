<?php

use App\Models\Survey;
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new class() extends Component {
    use Toast;

    public Survey $survey;
    public array $userAnswers = [];
    public array $results = [];

    public function mount(int $id): void
    {
        \Debugbar::disable();
        $this->survey = Survey::with('questions.answers')->findOrFail($id);

        if (auth()->user()->participatedSurveys()->where('survey_id', $id)->exists()) {
            abort(403);
        }
    }

    public function save()
    {
        $this->validate([
            'userAnswers' => 'required|array',
            'userAnswers.*' => 'required|integer|exists:answers,id',
        ]);

        $answersString = implode('', $this->userAnswers);

        auth()->user()->participatedSurveys()->attach($this->survey->id, [
            'answers' => $answersString,
        ]);

        $this->success(__('Thank you for completing the survey.'), redirectTo: '/');
    }

}; ?>

<div class="flex items-center justify-center my-8">
    <div class="w-full max-w-xl px-4 py-8 prose rounded-lg shadow-lg">

        <x-header title="{{ __('Survey') }} : {!! $survey->title !!}" />

        @foreach ($results as $questionId => $question)
            <h2>@lang('Question') {{ $loop->index + 1 }}</h2>
            <x-badge value="{!! $question['text'] !!}" class="p-4 badge-primary" /><br>
            <canvas id="chart-{{ $questionId }}" width="400" height="200"></canvas>
        @endforeach

    </div>
</div>


