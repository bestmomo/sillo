<?php

// Importations des classes nécessaires
use Livewire\Volt\Component;
use App\Models\Category;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Mary\Traits\Toast;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\WithPagination;

// Définition du composant Livewire avec le layout 'components.layouts.admin'
new 
#[Layout('components.layouts.admin')]
class extends Component {

    // Utilisation des traits Toast et WithPagination
    use Toast, WithPagination;

    // Déclaration des propriétés du composant
    public array $sortBy = ['column' => 'title', 'direction' => 'asc'];

    #[Rule('required|max:255|unique:categories,title')]
    public string $title = '';

    #[Rule('required|max:255|unique:posts,slug|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/')]
    public string $slug = '';

    // Méthode pour obtenir les en-têtes des colonnes
    public function headers(): array
    {
        return [
            ['key' => 'title', 'label' => __('Title')],
            ['key' => 'slug', 'label' => 'Slug'],
        ];
    }

    // Méthode appelée avant la mise à jour de la propriété $title
    public function updatedTitle($value): void
    {
        $this->generateSlug($value);
    }

    // Méthode pour générer le slug à partir du titre
    private function generateSlug(string $title): void
    {
        $this->slug = Str::of($title)->slug('-');
    }

    // Méthode pour supprimer une catégorie
    public function delete(Category $category): void
    {
        $category->delete();

        $this->success(__('Category deleted with success.'));
    }

    // Méthode pour sauvegarder une catégorie
    public function save(): void
    {
        $data = $this->validate();

        Category::create($data);

        $this->success(__('Category created with success.'));
    }

     // Méthode pour fournir des données additionnelles au composant
    public function with(): array
    {
        return [
            'categories' => Category::orderBy(...array_values($this->sortBy))->paginate(10),
            'headers' => $this->headers()
        ];
    }

}; ?>
<div>
    <x-header title="{{ __('Categories') }}" separator progress-indicator />

    <x-card>
        <x-table 
            striped 
            :headers="$headers" 
            :rows="$categories" 
            :sort-by="$sortBy" 
            link="/admin/categories/{id}/edit" 
            with-pagination
        >
            @scope('actions', $category)
                <x-button 
                    icon="o-trash" 
                    wire:click="delete({{ $category->id }})" 
                    wire:confirm="{{ __('Are you sure to delete this category?') }}" 
                    tooltip-left="{{ __('Delete') }}" 
                    spinner 
                    class="text-red-500 btn-ghost btn-sm" 
                />
            @endscope
        </x-table>
    </x-card>

    <x-card title="{{ __('Create a new category') }}">
        <x-form wire:submit="save"> 
            <x-input 
                label="{{ __('Title') }}" 
                wire:model.debounce.500ms="title" 
                wire:change="$refresh"
            />
            <x-input 
                type="text" 
                wire:model="slug" 
                label="{{ __('Slug') }}" 
            />
            <x-slot:actions>
                <x-button 
                    label="{{ __('Save') }}" 
                    icon="o-paper-airplane" 
                    spinner="save" 
                    type="submit" 
                    class="btn-primary" 
                />
            </x-slot:actions>
        </x-form>
    </x-card>
</div>