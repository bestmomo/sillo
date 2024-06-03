<?php

use Livewire\Volt\Component;
use App\Models\{ Category,Serie };
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Mary\Traits\Toast;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

new 
#[Layout('components.layouts.admin')]
class extends Component {

    use Toast, WithPagination;

    public int $category_id;

    public array $sortBy = ['column' => 'title', 'direction' => 'asc'];

    #[Rule('required|max:255|unique:categories,title')]
    public string $title = '';

    #[Rule('required|max:255|unique:posts,slug|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/')]
    public string $slug = '';

    // Définir l'ID de la catégorie par défaut lors du montage du composant.
    public function mount(): void
    {
        $category = Category::first();
        $this->category_id = $category->id;
    }

    // Définir les en-têtes de table.
    public function headers(): array
    {
        $headers = [
            ['key' => 'title', 'label' => __('Title')],
            ['key' => 'slug', 'label' => 'Slug'],
            ['key' => 'category_title', 'label' => __('Category')],
        ];

        if (Auth::user()->isAdmin()) {
            $headers[] = ['key' => 'user_name', 'label' => __('Author')];
        }

        return $headers;
    }

    // Mettre à jour le slug lorsque le titre change.
    public function updating($property, $value)
    {
        if($property == 'title') {
            $this->slug = Str::slug($value, '-');
        }
    }

    // Supprimer une série.
    public function delete(Serie $serie): void
    {
        $serie->delete();

        $this->warning(__('Serie deleted with success.'));
    }

    // Enregistrer une nouvelle série.
    public function save(): void
    {
        $data = $this->validate();
        
        Serie::create($data + [
            'category_id' => $this->category_id,
            'user_id' => Auth::id(),
        ]);

        $this->success(__('Serie created with success.'));
    }

    // Fournir les données nécessaires à la vue.
    public function with(): array
    {
        return [
            'categories' => Category::all(),
            'series' => Serie::withAggregate('category', 'title')
                ->when(Auth::user()->isAdmin(), fn(Builder $q) => $q->withAggregate('user', 'name'))
                ->when(!Auth::user()->isAdmin(), fn(Builder $q) => $q->where('user_id', Auth::id()))
                ->orderBy(...array_values($this->sortBy))
                ->paginate(10),
            'headers' => $this->headers(),
        ];
    }

}; ?>

<div>
    <x-header title="{{__('Series')}}" separator progress-indicator />
    @if($series->count() > 0) 
        <x-card>        
            <x-table striped :headers="$headers" :rows="$series" :sort-by="$sortBy" link="/admin/series/{id}/edit" with-pagination >
                @scope('cell_category.title', $post)
                    {{ $serie->category->title }}
                @endscope
                @scope('actions', $serie)
                    <x-button icon="o-trash" wire:click="delete({{ $serie->id }})" tooltip-left="{{ __('Delete') }}" wire:confirm="{{__('Are you sure to delete this serie?')}}" spinner class="btn-ghost btn-sm text-red-500" />
                @endscope
            </x-table>
        </x-card>
        <br>
    @endif
    <x-card class="" title="{{__('Create a new serie')}}">
 
        <x-form wire:submit="save">
            <x-select label="{{__('Category')}}" option-label="title" :options="$categories" wire:model="category_id" />
            <x-input label="{{__('Title')}}" wire:model="title" wire:change="$refresh" />
            <x-input type="text" wire:model="slug" label="{{ __('Slug') }}" />   
            <x-slot:actions>
                <x-button label="{{__('Save')}}" icon="o-paper-airplane" spinner="save" type="submit" class="btn-primary" />
            </x-slot:actions>
        </x-form>

    </x-card>
</div>