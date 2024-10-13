<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024.
 */

use App\Models\{Category, Post, Serie};
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\{Layout, Title};
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;

// Définition du composant Livewire avec le layout 'components.layouts.admin'
new #[Title('Edit Post'), Layout('components.layouts.admin')] class extends Component {
	// Utilisation des traits WithFileUploads et Toast
	use WithFileUploads, Toast;

	// Déclaration des propriétés du composant
	public bool $inSerie = false;
	public ?Post $seriePost = null;
	public int $postId;
	public Collection $series;
	public ?Collection $categories;
	public ?Serie $serie;
	public int $category_id;
	public ?int $serie_id;
	public Post $post;
	public string $body                  = '';
	public string $title                 = '';
	public string $slug                  = '';
	public bool $active                  = false;
	public bool $pinned                  = false;
	public string $seo_title             = '';
	public string $meta_description      = '';
	public string $meta_keywords         = '';
	public ?TemporaryUploadedFile $photo = null;

	// Initialisation du composant avec les données du post
	public function mount(Post $post): void
	{
		// Autorisation
		if (Auth()->user()->isRedac() && $post->user_id !== Auth()->id()) {
			abort(403);
		}

		$this->post = $post;
		$this->fill($this->post);
		$category = Category::with('series')->find($this->category_id);
		$this->series = $category->series;

		// Pas de série
		if ($this->series->isEmpty()) {
			$this->categories = Category::all();
			return;
		} 
		
		// Cas d'appartenance à une série
		if ($post->serie_id !== null) {
			$this->inSerie = true;
			$this->serie = Serie::find($this->serie_id);
			if($post->parent_id) {
				$this->seriePost = Post::find($post->parent_id);
			}
			// On regarde s'il a des enfants
			if(!Post::where('parent_id', $post->id)->get()->isEmpty()) {
				$this->series = new Collection;
				return;
			}
			$this->categories = Category::all();
			return;
		}

		$this->categories  = Category::all();
		$this->serie       = $this->series->isnotEmpty() ? $this->series->first() : null;
		$this->serie_id    = $this->serie? $this->serie->id : null;
		$this->seriePost   = $this->series->isNotEmpty() ? $this->serie->lastPost() : null;
	}

	// Méthode appelée lorsqu'une propriété est mise à jour
	public function updating($property, $value)
	{
		switch ($property) {
			case 'title':
				$this->slug = Str::slug($value);

				break;
			case 'serie_id':
				$this->serie     = Serie::find($value);
				$this->seriePost = $this->serie->lastPost();

				break;
			case 'category_id':
				$category     = Category::with('series')->find($value);
				$this->series = $category->series;

				if ($this->series->isNotEmpty()) {
					$this->seriePost = $this->series->first()->lastPost();
				} else {
					$this->inSerie = false;
				}

				break;
		}
	}

	// Méthode pour sauvegarder le post
	public function save()
	{
		$data = $this->validate([
			'title'            => 'required|string|max:255',
			'body'             => 'required|string|max:16777215',
			'category_id'      => 'required',
			'photo'            => 'nullable|image|max:2000',
			'active'           => 'required',
			'pinned'           => 'required',
			'slug'             => ['required', 'string', 'max:255', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Rule::unique('posts')->ignore($this->post->id)],
			'seo_title'        => 'required|max:70',
			'meta_description' => 'required|max:160',
			'meta_keywords'    => 'required|regex:/^[A-Za-z0-9-éèàù]{1,50}?(,[A-Za-z0-9-éèàù]{1,50})*$/',
		]);

		// Sauvegarde de l'image si elle a été modifiée
		if ($this->photo) {
			$date          = now()->format('Y/m'); // Détermination année et mois de publication genre 2024/06
			$path          = $date . '/' . basename($this->photo->store('photos/' . $date, 'public'));
			$data['image'] = $path;
		}

		// Série
		$data += [
			'serie_id'  => $this->inSerie? $this->serie_id : null,
			'parent_id' => $this->inSerie && $this->seriePost? $this->seriePost->id : null,
		];

		$data['body'] = replaceAbsoluteUrlsWithRelative($data['body']);

		if (!$this->post->active && $data['active']) {
			$data['created_at'] = now();
		}

		// Mise à jour du post
		$this->post->update(
			$data + [
				'category_id' => $this->category_id,
			],
		);

		// Affichage d'un message de succès
		$this->success(__('Post updated with success.'));
	}
}; ?>

<div>
    <x-header title="{{ __('Edit a post') }}" separator progress-indicator>
        <x-slot:actions>
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline lg:hidden"
                link="{{ route('admin') }}" />
        </x-slot:actions>
    </x-header>

    <x-card>
        <x-form wire:submit="save">
			@if($categories)
            	<x-select label="{{ __('Category') }}" option-label="title" :options="$categories" wire:model="category_id"
                wire:change="$refresh" />
			@endif
            @if (!$series->isEmpty())
                <x-collapse>
                    <x-slot:heading>
                        @lang('Serie')
                    </x-slot:heading>
                    <x-slot:content>
						<x-checkbox label="{{ __('Post belonging to a serie') }}" wire:model="inSerie"
							hint="{{ __('Serie is optional') }}" /><br>
						<x-select label="{{ __('Serie name') }}" option-label="title" :options="$series"
							wire:model="serie_id" wire:change="$refresh" /><br>
						<p>@lang('Previous post: ') {{ $seriePost? $seriePost->title : __('None') }}</p>
                    </x-slot:content>
                </x-collapse>
            @endif
            <div class="flex gap-6">
                <x-checkbox label="{{ __('Published') }}" wire:model="active" />
                <x-checkbox label="{{ __('Pinned') }}" wire:model="pinned" />
            </div>
            <x-input type="text" wire:model="title" label="{{ __('Title') }}"
                placeholder="{{ __('Enter the title') }}" wire:change="$refresh" />
            <x-input type="text" wire:model="slug" label="{{ __('Slug') }}" />
            <x-editor wire:model="body" label="{{ __('Content') }}" :config="config('tinymce.config')"
                folder="{{ 'photos/' . now()->format('Y/m') }}" />
            <x-card title="{{ __('SEO') }}" shadow separator>
                <x-input placeholder="{{ __('Title') }}" wire:model="seo_title" hint="{{ __('Max 70 chars') }}" />
                <br>
                <x-textarea label="{{ __('META Description') }}" wire:model="meta_description"
                    hint="{{ __('Max 160 chars') }}" rows="2" inline />
                <br>
                <x-textarea label="{{ __('META Keywords') }}" wire:model="meta_keywords"
                    hint="{{ __('Keywords separated by comma') }}" rows="1" inline />
            </x-card>
            <x-file wire:model="photo" label="{{ __('Featured image') }}"
                hint="{{ __('Click on the image to modify') }}" accept="image/png, image/jpeg">
                <img src="{{ asset('storage/photos/' . $post->image) }}" class="h-40" />
            </x-file>
            <x-slot:actions>
                <x-button label="{{ __('Preview') }}" icon="m-sun" link="{{ '/posts/' . $post->slug }}" external
                    class="btn-outline" />
                <x-button label="{{ __('Save') }}" icon="o-paper-airplane" spinner="save" type="submit"
                    class="btn-primary" />
            </x-slot:actions>
        </x-form>
    </x-card>
</div>
