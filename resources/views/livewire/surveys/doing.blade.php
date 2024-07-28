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

        $this->success(__('Thank you for completing the survey.'), redirectTo: '/surveys/show/' . $this->survey->id);
    }

}; ?>

<div class="flex items-center justify-center my-8">
    <div class="w-full max-w-xl px-4 py-8 prose rounded-lg shadow-lg">

        <x-header title="{{ __('Survey') }} : {!! $survey->title !!}" />

        <x-form wire:submit.prevent="save">

            @foreach ($survey->questions as $question)
                <h2>@lang('Question') {{ $loop->index + 1 }}</h2>
                <x-badge value="{!! $question->question_text !!}" class="p-4 badge-primary" /><br>
                @foreach($question->answers as $index => $answer)
                    <div>
                        <input type="radio" id="answer-{{ $answer->id }}" name="userAnswers[{{ $question->id }}]" value="{{ $index + 1 }}" wire:model="userAnswers.{{ $question->id }}">
                        <label for="answer-{{ $answer->id }}">{{ $answer->answer_text }}</label>
                    </div>
                @endforeach
            @endforeach

            <x-slot:actions>
                <x-button label="{{__('Cancel')}}" link="/" class="btn-outline" icon="o-hand-thumb-down" title="Cancel" />
                <x-button label="{{__('Submit')}}" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>

        </x-form>
    </div>
</div>


