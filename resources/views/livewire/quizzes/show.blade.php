<?php

use App\Models\Quiz;
use Livewire\Volt\Component;

new class() extends Component {
	
	public Quiz $quiz;
	public array $userAnswers = [];
    public bool $quizSubmitted = false;
    public array $results = [];
	public string $subtitle = '';

	public function mount(int $id): void
	{
		$this->quiz = Quiz::with('questions.answers', 'post:id,title')->findOrFail($id);
		$this->subtitle = $this->quiz->post ? __('Post') . ' : ' . $this->quiz->post->title : '';

        //if (auth()->user()->participatedQuizzes()->where('quiz_id', $id)->exists()) {
        //    abort(403);
        //}
	}

    public function save()
    {
        $results = [];
        $correctAnswersCount = 0;
        $totalAnswersCount = 0;

        foreach ($this->quiz->questions as $question) {
            $correctAnswers = $question->answers->where('is_correct', true)->pluck('id')->toArray();
            $userAnswers = array_keys($this->userAnswers[$question->id] ?? []);
            $correct = !array_diff($correctAnswers, $userAnswers) && !array_diff($userAnswers, $correctAnswers);

            if ($correct) {
                $correctAnswersCount++;
            }
            $totalAnswersCount++;

            $results[$question->id] = [
                'correct' => $correct,
                'correctAnswers' => $correctAnswers,
                'userAnswers' => $userAnswers,
            ];
        }

        $this->results = $results;
        $this->quizSubmitted = true;

        // Synchroniser les données pivot avec les réponses correctes et totales
        auth()->user()->participatedQuizzes()->attach([
            $this->quiz->id => [
                'correct_answers' => $correctAnswersCount,
                'total_answers' => $totalAnswersCount,
            ]
        ]);
    }
    
}; ?>

<div class="flex items-center justify-center my-8">
    <div class="w-full max-w-xl px-4 py-8 prose rounded-lg shadow-lg">
        <x-header 
            title="{{ __('Quiz') }} : {!! $quiz->title !!}" 
            subtitle="{{ $subtitle }}" 
        />

        <x-form wire:submit.prevent="save">

            @foreach ($quiz->questions as $question)
                <h2>
                    @lang('Question') {{ $loop->index + 1 }}
                    @if($quizSubmitted)
                        @if(isset($results[$question->id]) && $results[$question->id]['correct'])
                            <x-icon name="c-check-circle" class="text-green-500 w-9 h-9" />
                        @else
                            <x-icon name="c-check-circle" class="text-red-500 w-9 h-9" />
                        @endif
                    @endif
                </h2>
                <x-badge value="{!! $question->question_text !!}" class="p-4 badge-primary" /><br>
                @foreach($question->answers as $answer)
                    @php
                        $isCorrect = in_array($answer->id, $results[$question->id]['correctAnswers'] ?? []);
                        $isChecked = in_array($answer->id, $results[$question->id]['userAnswers'] ?? []);
                        $alertClass = '';

                        if ($quizSubmitted) {
                            if (($isChecked && !$isCorrect) || (!$isChecked && $isCorrect)) {
                                $alertClass = 'alert-warning';
                            }
                        }
                    @endphp
                    <x-alert class="{{ $alertClass }}">
                        <x-checkbox
                            label="{!! $answer->answer_text !!}"
                            wire:model="userAnswers.{{ $question->id }}.{{ $answer->id }}"
                            :disabled="$quizSubmitted"
                        />
                    </x-alert>
                @endforeach
            @endforeach

            <x-slot:actions>
                <x-button label="{{__('Cancel')}}" link="/" class="btn-outline" icon="o-hand-thumb-down" title="Cancel" />
                <x-button label="{{__('Submit')}}" class="btn-primary" type="submit" spinner="save" :disabled="$quizSubmitted" />
            </x-slot:actions>

        </x-form>

        @if($quizSubmitted)
            <div class="mt-4">
                <h2>@lang('Result') :
                    @php
                        $totalCorrect = 0;
                        $totalQuestions = count($results);
                    @endphp

                    @foreach ($results as $questionId => $result)
                        @if($result['correct'])
                            @php $totalCorrect++; @endphp
                        @endif
                    @endforeach
            
                    <x-badge value="{{ $totalCorrect }}/{{ $totalQuestions }}" class="p-4 badge-primary" />
                </h2>
            </div>
        @endif
    </div>
</div>
