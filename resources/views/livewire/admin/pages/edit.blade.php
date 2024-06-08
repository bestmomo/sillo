<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Page;
use Mary\Traits\Toast;
use illuminate\Support\Str;
use Illuminate\Validation\Rule;

new 
#[Layout('components.layouts.admin')]
class extends Component {

    use Toast;

    public Page $page;
    public string $body = '';
    public string $title = '';
    public string $slug = '';

    // Initialise le composant avec la page donnée.
    public function mount(Page $page): void
    {
        $this->page = $page;

        $this->fill($this->page);
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

    // Enregistre les modifications de la page
    public function save()
    {
        $data = $this->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|max:65000',
            'slug' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('pages')->ignore($this->page->id),
            ],
        ]);

        $this->page->update($data);

        $this->success(__('Page edited with success.'), redirectTo: '/admin/pages/index');
    }

}; ?>

<div>
    <x-card title="{{ __('Edit a page') }}" shadow separator progress-indicator >
        <x-form wire:submit="save" >
            <x-input type="text" wire:model="title" label="{{ __('Title') }}" placeholder="{{ __('Enter the title') }}" wire:change="$refresh" />
            <x-input type="text" wire:model="slug" label="{{ __('Slug') }}" />
            <x-editor 
                wire:model="body"
                label="{{ __('Content') }}"
                :config="config('tinymce.config')" 
                folder="{{ 'photos/' . now()->format('Y/m') }}" />
            <x-slot:actions>
                <x-button label="{{__('Cancel')}}" icon="o-hand-thumb-down" class="btn-outline" link="/admin/pages/index" />
                <x-button label="{{__('Save')}}" icon="o-paper-airplane" spinner="save" type="submit" class="btn-primary" />
            </x-slot:actions>
        </x-form>    
    </x-card>
</div>
