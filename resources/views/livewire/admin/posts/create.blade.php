<?php

// Importations des classes nécessaires
use App\Models\{Category, Post, Serie};
use Illuminate\Support\Collection;
use illuminate\Support\Str;
use Livewire\Attributes\{Layout, Rule};
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;

// Définition du composant Livewire avec le layout 'components.layouts.admin'
new #[Layout('components.layouts.admin')] class extends Component {
	// Utilisation des traits WithFileUploads et Toast
	use WithFileUploads;
	use Toast;

	// Déclaration des propriétés du composant
	public bool $inSerie = false;
	public Collection $seriePosts;
	public ?Post $seriePost = null;
	public int $postId;
	public Collection $series;
	public ?Serie $serie = null;
	public int $category_id;
	public int $serie_id;

	// Déclaration des règles de validation pour les propriétés
	#[Rule('required|string|max:16777215')]
	public string $body = '';

	#[Rule('required|string|max:255')]
	public string $title = '';

	#[Rule('required|max:255|unique:posts,slug|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/')]
	public string $slug = '';

	#[Rule('required')]
	public bool $active = false;

	#[Rule('required')]
	public bool $pinned = false;

	#[Rule('required|max:70')]
	public string $seo_title = '';

	#[Rule('required|max:160')]
	public string $meta_description = '';

	#[Rule('required|regex:/^[A-Za-z0-9-éèàù]{1,50}?(,[A-Za-z0-9-éèàù]{1,50})*$/')]
	public string $meta_keywords = '';

	#[Rule('required|image|max:2000')]
	public ?TemporaryUploadedFile $photo = null;

	// Initialisation du composant avec les données par défaut
	public function mount(): void
	{
		$category          = Category::with('series')->first();
		$this->category_id = $category->id;
		$this->series      = $category->series;
		$this->serie       = $this->series->isEmpty() ? null : $this->series->first();
		$this->serie_id    = $this->serie? $this->serie->id : null;
		$this->seriePost   = $this->series->isEmpty()? null : $this->serie->lastPost();
	}

	// Méthode appelée lorsqu'une propriété est mise à jour
	public function updating($property, $value)
	{
		switch ($property) {
			case 'title':
				$this->slug      = Str::slug($value);
				$this->seo_title = $value;

				break;
			case 'serie_id':
				$this->serie     = Serie::find($value);
				$this->seriePost = $this->serie->lastPost();

				break;
			case 'category_id':
				$category     = Category::with('series')->find($value);
				$this->series = $category->series;

				if ($this->series->count() > 0) {
					$this->seriePost = $this->series->first()->lastPost();
				} else {
					$this->inSerie = false;
				}

				break;
		}
	}

	// Méthode pour sauvegarder l'article'
	public function save()
	{
		// Validation des données
		$data = $this->validate();

		// Détermination année et mois de publication genre 2024/06
		$date = now()->format('Y/m');

		// Sauvegarde de l'image
		$path = $date . '/' . basename($this->photo->store('photos/' . $date, 'public'));

		// Vérification si l'article est dans une série
		if ($this->inSerie) {
			$data += [
				'serie_id'  => $this->serie_id,
				'parent_id' => $this->seriePost? $this->seriePost->id : null,
			];
		}

		$data['body'] = replaceAbsoluteUrlsWithRelative($data['body']);

		// Création de l'article
		Post::create(
			$data + [
				'user_id'     => Auth::id(),
				'category_id' => $this->category_id,
				'image'       => $path,
			],
		);

		// Affichage d'un message de succès et redirection
		$this->success(__('Post added with success.'), redirectTo: '/admin/posts/index');
	}

	// Méthode pour fournir des données additionnelles au composant
	public function with(): array
	{
		return [
			'categories' => Category::all(),
		];
	}
}; ?>

<div>
    <x-header title="{{ __('Add a post') }}" separator progress-indicator>
        <x-slot:actions>
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline lg:hidden"
                link="{{ route('admin') }}" />
        </x-slot:actions>
    </x-header>
    <x-card>
        <x-form wire:submit="save">
            <x-select label="{{ __('Category') }}" option-label="title" :options="$categories" wire:model="category_id"
                wire:change="$refresh" />
            @if ($this->series->count() > 0)
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
            <br>
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
            <hr>
            <x-file wire:model="photo" label="{{ __('Featured image') }}"
                hint="{{ __('Click on the image to modify') }}" accept="image/png, image/jpeg">
                <img src="{{ $photo == '' ? '/ask.jpg' : $photo }}" class="h-40" />
            </x-file>
            <x-slot:actions>
                <x-button label="{{ __('Save') }}" icon="o-paper-airplane" spinner="save" type="submit"
                    class="btn-primary" />
            </x-slot:actions>
        </x-form>
    </x-card>
</div>
