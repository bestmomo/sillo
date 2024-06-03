<?php

// Importations des classes nécessaires
use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\{ Category, Serie, Post };
use Livewire\Attributes\Rule;
use Illuminate\Support\Collection;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;
use illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

// Définition du composant Livewire avec le layout 'components.layouts.admin'
new 
#[Layout('components.layouts.admin')]
class extends Component {

    // Utilisation des traits WithFileUploads et Toast
    use WithFileUploads, Toast;
    
    // Déclaration des propriétés du composant
    public bool $inSerie = false;
    public Collection $seriePosts;
    public Post $seriePost;
    public int $postId;
    public Collection $series;
    public Serie $serie;
    public int $category_id;
    public int $serie_id;

    // Déclaration des règles de validation pour les propriétés
    #[Rule('required|max:65000')]
    public string $body = '';

    #[Rule('required|max:255')]
    public string $title = '';

    #[Rule('required|max:255|unique:posts,slug|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/')]
    public string $slug = '';

    #[Rule('required')]
    public bool $active = false;

    #[Rule('required|image|max:2000')]
    public TemporaryUploadedFile|null $photo = null;

    // Initialisation du composant avec les données par défaut
    public function mount(): void
    {
        $category = Category::with('series')->first();
        $this->category_id = $category->id;
        $this->series = $category->series;
        $this->serie = $this->series->first();
        $this->seriePost = $this->serie->lastPost();
    }

    // Méthode appelée lorsqu'une propriété est mise à jour
    public function updating($property, $value)
    {
        switch ($property) {
            case 'title':
                $this->slug = Str::slug($value);
                break;              
            case 'serie_id':
                $this->serie = Serie::find($value);
                $this->seriePost = $this->serie->lastPost();
                break;
            case 'category_id':
                $category = Category::with('series')->find($value);
                $this->series = $category->series;

                if($this->series->count() > 0) {
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
        if($this->inSerie) {
            $data += [
                'serie_id' => $this->serie_id,
                'parent_id' => $this->seriePost->id,
            ];
        }

        // Création de l'article
        Post::create($data + [
            'user_id' => Auth::id(), 
            'category_id' => $this->category_id,
            'image' => $path,
            'excerpt' => Str::limit($this->body, 300),
        ]);

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
    <x-card title="{{ __('Add an article') }}" shadow separator progress-indicator >
        <x-form wire:submit="save" >
            <x-select label="{{__('Category')}}" option-label="title" :options="$categories" wire:model="category_id" wire:change="$refresh" />
            @if($this->series->count() > 0)
                <x-collapse>                
                    <x-slot:heading>
                        @lang('Serie')
                    </x-slot:heading>
                    <x-slot:content>
                        <x-checkbox label="{{ __('Post belonging to a serie') }}" wire:model="inSerie" hint="{{ __('Serie is optional') }}" /><br>
                        <x-select label="{{__('Serie name')}}" option-label="title" :options="$series" wire:model="serie_id" wire:change="$refresh" /><br>
                        <p>@lang('Previous post: ') {{ $seriePost->title }}</p>
                    </x-slot:content>
                </x-collapse>
            @endif
            <br>
            <x-checkbox label="{{ __('Published') }}" wire:model="active" />
            <x-input type="text" wire:model="title" label="{{ __('Title') }}" placeholder="{{ __('Enter the title') }}" wire:change="$refresh" />
            <x-input type="text" wire:model="slug" label="{{ __('Slug') }}" />
            <x-editor 
                wire:model="body"
                label="{{ __('Content') }}"
                :config="config('tinymce.config')" 
                folder="{{ 'photos/' . now()->format('Y/m') }}" />
            <x-file wire:model="photo" label="{{__('Featured image')}}" hint="{{ __('Click on the image to modify') }}" accept="image/png, image/jpeg">
                <img src="{{ $photo == '' ? '/ask.jpg' : $photo }}" class="h-40" />
            </x-file>
            <x-slot:actions>
                <x-button label="{{__('Save')}}" icon="o-paper-airplane" spinner="save" type="submit" class="btn-primary" />
            </x-slot:actions>
        </x-form>    
    </x-card>
</div>
