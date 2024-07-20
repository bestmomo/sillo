<?php

use App\Models\Survey;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\DB;

new class() extends Component {

    public Survey $survey;
    public array $results = [];

    public function mount(int $id): void
    {
        $this->survey = Survey::with(['questions.answers', 'participants'])->findOrFail($id);

        $this->loadResults();
    }

    private function loadResults(): void
    {
        // Initialiser les résultats avec les questions
        $questions = $this->survey->questions->mapWithKeys(function($question) {
            return [$question->id => [
                'text' => $question->question_text,
                'answers' => array_fill(0, $question->answers->count(), 0)
            ]];
        })->toArray();

        // Parcourir tous les participants et leurs réponses
        foreach($this->survey->participants as $participant) {
            $answers = str_split($participant->pivot->answers);

            foreach($answers as $questionIndex => $answer) {
                $questionId = $this->survey->questions[$questionIndex]->id;
                if(isset($questions[$questionId])) {
                    $questions[$questionId]['answers'][$answer - 1]++;
                }
            }
        }

        $this->results = $questions;
    }

}; ?>

<div class="flex items-center justify-center my-8">
    <div class="w-full max-w-xl px-4 py-8 prose rounded-lg shadow-lg">

        <x-header title="{{ __('Survey') }} : {!! $survey->title !!}" />

        @foreach ($results as $question)
            <h2>@lang('Question') {{ $loop->index + 1 }}</h2>
            <x-badge value="{!! $question['text'] !!}" class="p-4 badge-primary" /><br>

            @foreach($question['answers'] as $index => $answerCount)
                <div>
                    <p>{{ $survey->questions[$loop->parent->index]->answers[$index]->answer_text }}: {{ $answerCount }} votes</p>
                </div>
            @endforeach
        @endforeach

    </div>
</div>
