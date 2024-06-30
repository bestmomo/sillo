<?php

// Importations des classes nécessaires
use Mary\Traits\Toast;
use illuminate\Support\Str;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Illuminate\Support\Collection;
use App\Models\{Category, Serie, Post};
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

// Définition du composant Livewire avec le layout 'components.layouts.admin'
new
#[Title('Edit Post'), Layout('components.layouts.admin')]
class extends Component {
    // Utilisation des traits WithFileUploads et Toast
    use WithFileUploads, Toast;

    // Déclaration des propriétés du composant
    public bool $inSerie = false;
    public Collection $seriePosts;
    public Post $seriePost;
    public int $postId;
    public Collection $series;
    public Serie|null $serie;
    public int $category_id;
    public int|null $serie_id;
    public Post $post;
    public string $body = '';
    public string $excerpt = '';
    public string $title = '';
    public string $slug = '';
    public bool $active = false;
    public string $seo_title = '';
    public string $meta_description = '';
    public string $meta_keywords = '';
    public TemporaryUploadedFile|null $photo = null;

    // Initialisation du composant avec les données du post
    public function mount(Post $post): void
    {
        if (Auth()->user()->isRedac() && $post->user_id !== Auth()->id()) {
            abort(403);
        }

        $this->post = $post;

        $this->fill($this->post);

        $category = Category::find($this->category_id);
        $this->series = $category->series;
        if ($this->series->count() > 0) {
            $this->serie = $this->serie_id ? Serie::find($this->serie_id) : $this->series->first();
            $this->seriePosts = $this->serie->posts;
            $this->seriePost = $this->seriePosts->first();
        }
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

                if ($this->series->count() > 0) {
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
            'title' => 'required|string|max:255',
            'body' => 'required|max:65000',
            'category_id' => 'required',
            'photo' => 'nullable|image|max:2000',
            'active' => 'required',
            'slug' => ['required', 'string', 'max:255', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Rule::unique('posts')->ignore($this->post->id)],
            'seo_title' => 'required|max:70',
            'meta_description' => 'required|max:160',
            'meta_keywords' => 'required|regex:/^[A-Za-z0-9-éèàù]{1,50}?(,[A-Za-z0-9-éèàù]{1,50})*$/',
        ]);

        // Sauvegarde de l'image si elle a été modifiée et suppression de l'ancienne
        if ($this->photo) {
            Storage::disk('public')->delete('photos/' . $this->post->image);
            $date = now()->format('Y/m'); // Détermination année et mois de publication genre 2024/06
            $path = $date . '/' . basename($this->photo->store('photos/' . $date, 'public'));
            $data['image'] = $path;
        }

        // Série
        if ($this->inSerie) {
            $data += [
                'serie_id' => $this->serie_id,
                'parent_id' => $this->seriePost->id,
            ];
        }

        $data['body'] = replaceAbsoluteUrlsWithRelative($data['body']);

        // Mise à jour du post
        $this->post->update(
            $data + [
                'category_id' => $this->category_id,
            ],
        );

        // Affichage d'un message de succès
        $this->success(__('Post updated with success.'));
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
  <x-card title="{{ __('Edit an article') }}" shadow separator progress-indicator>
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
          <x-select label="{{ __('Serie name') }}" option-label="title" :options="$series" wire:model="serie_id"
            wire:change="$refresh" /><br>
          <p>@lang('Previous post: ') {{ $seriePost->title }}</p>
        </x-slot:content>
      </x-collapse>
      @endif
      <x-checkbox label="{{ __('Published') }}" wire:model="active" />
      <x-input type="text" wire:model="title" label="{{ __('Title') }}" placeholder="{{ __('Enter the title') }}"
        wire:change="$refresh" />
      <x-input type="text" wire:model="slug" label="{{ __('Slug') }}" />
      <x-editor wire:model="body" label="{{ __('Content') }}" :config="config('tinymce.config')"
        folder="{{ 'photos/' . now()->format('Y/m') }}" />
      <x-card title="{{ __('SEO') }}" shadow separator>
        <x-input placeholder="{{ __('Title') }}" wire:model="seo_title" hint="{{ __('Max 70 chars') }}" />
        <br>
        <x-textarea label="{{ __('META Description') }}" wire:model="meta_description" hint="{{ __('Max 160 chars') }}"
          rows="2" inline />
        <br>
        <x-textarea label="{{ __('META Keywords') }}" wire:model="meta_keywords"
          hint="{{ __('Keywords separated by comma') }}" rows="1" inline />
      </x-card>
      <x-file wire:model="photo" label="{{ __('Featured image') }}" hint="{{ __('Click on the image to modify') }}"
        accept="image/png, image/jpeg">
        <img src="{{ asset('storage/photos/' . $post->image) }}" class="h-40" />
      </x-file>
      <x-slot:actions>
        <x-button label="{{ __('Cancel') }}" icon="o-hand-thumb-down" class="btn-outline" link="/admin/posts/index" />
        <x-button label="{{ __('Preview') }}" icon="m-sun" link="{{ '/posts/' . $post->slug }}" external
          class="btn-outline" />
        <x-button label="{{ __('Save') }}" icon="o-paper-airplane" spinner="save" type="submit" class="btn-primary" />
      </x-slot:actions>
    </x-form>
  </x-card>
</div>
