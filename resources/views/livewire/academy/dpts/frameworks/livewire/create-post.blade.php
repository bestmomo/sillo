<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024.
 */

use Mary\Traits\Toast;
use App\Models\AcademyPost;
use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Rule, Title};

new #[Title('New Post')] #[Layout('components.layouts.academy')] class extends Component
{
	use Toast;

	#[Rule('required', message: 'Yo, add a title!')]
	#[Rule('min:3', message: 'Yo, more than 2 chars, please!')]
	public $title = '';

	#[Rule('required', as: 'content (textarea)')]
	public $content = '';

	public function save()
	{
		try
		{
			$this->validate();
			AcademyPost::create([
				'title'   => $this->title,
				'content' => $this->content,
			]);
			$this->success('Post added !');
			$this->redirect('/framework/livewire/blog');
		}
		catch (Exception $e)
		{
			// Vous pouvez enregistrer l'erreur dans le journal Laravel avec Log::error
			Log::error($e->getMessage());
			// Ou vous pouvez définir un message d'erreur à afficher dans votre composant
			$this->addError('form', 'Une erreur est survenue lors de la sauvegarde du formulaire : ' . $e->getMessage());
		}
	}
}; ?>

<div>
    <x-header class="pb-0 mb-[-14px] font-new text-green-400" title="Formulaire" shadow separator progress-indicator />

    <p>Titre actuel en majuscules : <span x-text="$wire.title.toUpperCase()"></span></p>

    @php
        $contentLength = strlen($content);
        $maxChars = env('APP_MAX_NUMBER_OF_CHARS_IN_COMMENTS_FORM');
        $messageKey = $contentLength >= $maxChars ? 'All chars used :m' : 'Chars2 used: :n :m';
    @endphp

    <form wire:submit="save">
        @error('title')
            Attention: <em>{{ $message }}</em><br>
        @enderror

        <label for="title">
            <span>Titre</span>
            <x-input class="mt-1 mb-2" type="text" wire:model='title'></x-input>
        </label>

        <label for="content">
            <span>Contenu (Caractères comptabilisés)</span>
            <x-textarea class="mt-1" name="" id="" cols="30" rows="7"
                wire:model.live='content' maxlength="{{ $maxChars }}"></x-textarea>
        </label>
        <span x-text="'{{ trans_choice($messageKey, $contentLength, ['n' => $contentLength, 'm' => $maxChars]) }}'"></span>

        <div class="text-right w-full">
            <x-button type="submit" class="btn-primary mt-2 mr-5" disabled>Enregistrer</x-button>
        </div>
    </form>
</div>
