<?php

use App\Models\Survey;
use Livewire\Volt\Component;

new class() extends Component
{
	public Survey $survey;
	public array $results = [];
	public array $charts  = [];

	public function mount(int $id): void
	{
		$this->survey = Survey::with(['questions.answers', 'participants'])->findOrFail($id);

		$this->loadResults();
	}

	private function loadResults(): void
	{
		// Initialiser les résultats avec les questions
		$questions = $this->survey->questions->mapWithKeys(function ($question)
		{
			return [$question->id => [
				'text'         => $question->question_text,
				'answers'      => array_fill(0, $question->answers->count(), 0),
				'answer_texts' => $question->answers->pluck('answer_text')->toArray(),
			]];
		})->toArray();

		// Parcourir tous les participants et leurs réponses
		foreach ($this->survey->participants as $participant)
		{
			$answers = str_split($participant->pivot->answers);

			foreach ($answers as $questionIndex => $answer)
			{
				$questionId = $this->survey->questions[$questionIndex]->id;
				if (isset($questions[$questionId]))
				{
					++$questions[$questionId]['answers'][$answer - 1];
				}
			}
		}

		// Préparer les données pour Chart.js
		$chartData = [];
		foreach ($questions as $question)
		{
			$chartData[] = [
				'type' => 'bar',
				'data' => [
					'labels'   => $question['answer_texts'],
					'datasets' => [
						[
							'label'           => $question['text'],
							'data'            => $question['answers'],
							'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
							'borderColor'     => 'rgba(54, 162, 235, 1)',
							'borderWidth'     => 1,
						],
					],
				],
				'options' => [
					'indexAxis' => 'y',
					'scales'    => [
						'y' => [
							'beginAtZero' => true,
						],
					],
					'plugins' => [
						'legend' => [
							'display' => false,
						],
					],
				],
			];
		}

		$this->charts  = $chartData;
		$this->results = $questions;
	}
}; ?>

<div class="flex items-center justify-center my-8">
    <div class="w-full max-w-xl px-4 py-8 prose rounded-lg shadow-lg">

        <x-header title="{{ __('Survey') }} : {!! $survey->title !!}" subtitle="{{ __('The results') }}" />

        @foreach ($results as $questionId => $question)
            <h2>@lang('Question') {{ $loop->index + 1 }}</h2>
            <x-badge value="{!! $question['text'] !!}" class="p-4 mb-4 badge-primary" />
            <x-chart wire:model="charts.{{ $loop->index }}" />
        @endforeach

    </div>
</div>

