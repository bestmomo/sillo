<?php

use App\Models\Quiz;
use Livewire\Volt\Component;

new class() extends Component
{
	public Quiz $quiz;
	public array $userAnswers  = [];
	public bool $quizSubmitted = false;
	public array $results      = [];
	public string $subtitle    = '';
	public bool $myModal       = false;
	public string $chatAnswer  = '';

	public function mount(int $id): void
	{
		$this->quiz     = Quiz::with('questions.answers', 'post:id,title')->findOrFail($id);
		$this->subtitle = $this->quiz->post ? __('Post') . ' : ' . $this->quiz->post->title : '';

		if (auth()->user()->participatedQuizzes()->where('quiz_id', $id)->exists())
		{
			abort(403);
		}
	}

	public function save()
	{
		$results             = [];
		$correctAnswersCount = 0;
		$totalAnswersCount   = 0;

		foreach ($this->quiz->questions as $question)
		{
			$correctAnswers = $question->answers->where('is_correct', true)->pluck('id')->toArray();
			$userAnswers    = array_keys($this->userAnswers[$question->id] ?? []);
			$correct        = !array_diff($correctAnswers, $userAnswers) && !array_diff($userAnswers, $correctAnswers);

			if ($correct)
			{
				++$correctAnswersCount;
			}
			++$totalAnswersCount;

			$results[$question->id] = [
				'correct'        => $correct,
				'correctAnswers' => $correctAnswers,
				'userAnswers'    => $userAnswers,
			];
		}

		$this->results       = $results;
		$this->quizSubmitted = true;

		// Synchroniser les données pivot avec les réponses correctes et totales
		auth()->user()->participatedQuizzes()->attach([
			$this->quiz->id => [
				'correct_answers' => $correctAnswersCount,
				'total_answers'   => $totalAnswersCount,
			],
		]);
	}

	public function explainError(int $questionId): void
	{
		$currentQuestionId = $questionId;
		$question          = $this->quiz->questions->find($questionId);

		if ($question)
		{
			$currentQuestionText = $question->question_text;
			$wrongAnswerText     = null;
			$correctAnswerText   = null;

			foreach ($question->answers as $answer)
			{
				$isCorrect = $answer->is_correct;
				$isChecked = isset($this->userAnswers[$questionId]) && array_key_exists($answer->id, $this->userAnswers[$questionId]);

				if ($isChecked && !$isCorrect)
				{
					$wrongAnswerText = $answer->answer_text;
				}
				elseif (!$isChecked && $isCorrect)
				{
					$correctAnswerText = $answer->answer_text;
				}
			}
		}

		// Récupération de la clé API depuis l'environnement
		$token = env('GPT_API_KEY');

		// Récupération du modèle GPT depuis l'environnement
		$gptModel = env('GPT_MODEL', 'gpt-3.5-turbo'); // Utilisation par défaut si la clé n'est pas définie

		// Définition du prompt
		$prompt = __("You're an expert in the Laravel framework, renowned for your ability to explain every concept clearly and patiently. Your aim is to provide detailed and understandable explanations, adapted to all skill levels.");

		$prompt .= "\n" . __('I made a quiz and had to answer to questions') . ": \n" . $currentQuestionText;
		$prompt .= "\n" . __('I answered') . ": \n" . $wrongAnswerText;
		$prompt .= "\n" . __('Correct answer was') . ": \n" . $correctAnswerText;
		$prompt .= "\nexplain my error";

		// Préparation de la requête
		$payload = [
			'model'    => $gptModel,
			'messages' => [
				[
					'role'    => 'user',
					'content' => $prompt,
				],
			],
		];

		// Envoi de la requête à l'API OpenAI
		try
		{
			$response = Http::withToken($token)
				->withHeaders([
					'Content-Type' => 'application/json',
				])
				->post('https://api.openai.com/v1/chat/completions', $payload);

			// Vérification du statut de la réponse
			if ($response->successful())
			{
				// Décodage de la réponse et récupération du contenu
				$this->chatAnswer = json_decode($response->body())->choices[0]->message->content;
				$this->myModal    = true;
			}
			else
			{
				// Gestion des erreurs
				throw new Exception(__('Error in API response: ') . $response->body());
			}
		}
		catch (Exception $e)
		{
			$erreur_obj = json_decode($response->body());
			$error_code = $erreur_obj->error->code;
			Log::error('Failed to get answer from OpenAI: ' . $e->getMessage());
			$this->answer = __('An error occurred while trying to retrieve the answer') . ' (' . __($error_code) . ')' . "\n";
		}
	}
}; ?>

<div class="flex items-center justify-center my-8">
    <div class="w-full max-w-xl px-4 py-8 prose rounded-lg shadow-lg">

        <x-modal wire:model="myModal">
            <p>{{ $this->chatAnswer }}</p>
        </x-modal>

        <x-header 
            title="{{ __('Quiz') }} : {!! $quiz->title !!}" 
            subtitle="{!! $subtitle !!}" 
            size="text-2xl sm:text-3xl md:text-4xl" 
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
                            <x-button label="{{__('Explain my error')}}" wire:click="explainError({{ $question->id }})" class="btn-info btn-sm" spinner />
                        @endif
                    @endif
                </h2>
                <x-alert title="{!! $question->question_text !!}" class="alert-info" /><br>
                @foreach($question->answers as $answer)
                    @php
                        $isCorrect = in_array($answer->id, $results[$question->id]['correctAnswers'] ?? []);
                        $isChecked = in_array($answer->id, $results[$question->id]['userAnswers'] ?? []);
                        $alertClass = '';
                        if ($quizSubmitted) {
                            if ($isChecked && !$isCorrect) {
                                $alertClass = 'alert-warning';
                            } else if (!$isChecked && $isCorrect) {
                                $alertClass = 'alert-success';
                            }
                        }
                    @endphp
                    <x-alert class="{{ $alertClass }}" style="justify-items: left;">
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
