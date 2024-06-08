<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Page;
use Livewire\Attributes\Rule;
use Mary\Traits\Toast;
use illuminate\Support\Str;

new 
#[Layout('components.layouts.admin')]
class extends Component {

    use Toast;
    
    #[Rule('required|max:65000')]
    public string $body = '';

    #[Rule('required|max:255')]
    public string $title = '';

    #[Rule('required|max:255|unique:posts,slug|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/')]
    public string $slug = '';

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

    // Enregistre la nouvelle page
    public function save()
    {
        $data = $this->validate();

        Page::create($data);

        $this->success(__('Page added with success.'), redirectTo: '/admin/pages/index');
    }

}; ?>

<div>
    <x-card title="{{ __('Add a page') }}" shadow separator progress-indicator>
        <x-form wire:submit="save">
            <x-input type="text" wire:model="title" label="{{ __('Title') }}" placeholder="{{ __('Enter the title') }}" wire:change="$refresh" />
            <x-input type="text" wire:model="slug" label="{{ __('Slug') }}" />
            <x-editor 
                wire:model="body"
                label="{{ __('Content') }}"
                :config="config('tinymce.config')" 
                folder="{{ 'photos/' . now()->format('Y/m') }}" />
            <x-slot:actions>
                <x-button label="{{ __('Save') }}" icon="o-paper-airplane" spinner="save" type="submit" class="btn-primary" />
            </x-slot:actions>
        </x-form>
    </x-card>
</div>
