<?php

// Importations des classes nécessaires
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Mary\Traits\Toast;

// Définition du composant Livewire avec le layout 'components.layouts.admin'
new
#[Layout('components.layouts.admin')]
class extends Component {
	// Utilisation du trait Toast pour les notifications
	use Toast;

	// Déclaration des propriétés du composant
	public Category $category;
	public string $title = '';
	public string $slug  = '';

	// Méthode mount appelée lors de l'initialisation du composant
	public function mount(Category $category): void
	{
		$this->category = $category;
		$this->fill($this->category->toArray());
	}

	// Méthode appelée avant la mise à jour de la propriété $title
	public function updatedTitle($value): void
	{
		$this->generateSlug($value);
	}

	// Méthode pour sauvegarder les modifications de la catégorie
	public function save(): void
	{
		$data = $this->validate($this->rules());

		$this->category->update($data);

		$this->success(__('Category updated successfully.'), redirectTo: '/admin/categories/index');
	}

	// Règles de validation pour les données
	protected function rules(): array
	{
		return [
			'title' => 'required|string|max:255',
			'slug'  => [
				'required',
				'string',
				'max:255',
				'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
				Rule::unique('categories')->ignore($this->category->id),
			],
		];
	}

	// Méthode pour générer le slug à partir du titre
	private function generateSlug(string $title): void
	{
		$this->slug = Str::of($title)->slug('-');
	}
}; ?>

<div>
    <x-card class="" title="{{__('Edit a category')}}">
 
        <x-form wire:submit="save"> 
            <x-input 
                label="{{__('Title')}}" 
                wire:model.debounce.500ms="title" 
                wire:change="$refresh" />
            <x-input 
                type="text" 
                wire:model="slug" 
                label="{{ __('Slug') }}" />   
            <x-slot:actions>
                <x-button 
                    label="{{__('Cancel')}}" 
                    icon="o-hand-thumb-down" 
                    class="btn-outline" 
                    link="/admin/categories/index" />
                <x-button 
                    label="{{__('Save')}}" 
                    icon="o-paper-airplane" 
                    spinner="save" 
                    type="submit" 
                    class="btn-primary" />
            </x-slot:actions>
        </x-form>

    </x-card>
</div>