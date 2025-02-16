<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

use Mary\Traits\Toast;
use App\Models\AcademyPost;
use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Rule, Title};

new
#[Title('New Form')]
#[Layout('components.layouts.academy')]
class extends Component
{
	use Toast;

	#[Rule('required', message: 'Yo, add a title!')]
	#[Rule('min:3', message: 'Yo, more than 3 chars, please!')]
	public $title = '';

	#[Rule('required', as: 'content (textarea)')]
	public $content = '';

	public function save()
	{
		$this->validate();
		AcademyPost::create([
			'title'   => $this->title,
			'content' => $this->content,
		]);
		$this->success('Post added !');
		$this->redirect('/framework/livewire/blog');
	}
};
