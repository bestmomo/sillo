<?php

use Livewire\Volt\Component;
use App\Models\Footer;
use Livewire\Attributes\Layout;
use Mary\Traits\Toast;
use Illuminate\Validation\Rule;

new 
#[Layout('components.layouts.admin')]
class extends Component {

    use Toast;

    public Footer $footer;
    public string $label = '';
    public string|null $link = null;

    // Initialise le composant avec le footer donné.
    public function mount(Footer $footer): void
    {
        $this->footer = $footer;

        $this->fill($this->footer);
    }

    // Enregistrer les modifications apportées au footer.
    public function save(): void
    {
        $data = $this->validate([
            'label' => [
                'required',
                'string',
                'max:255',
                Rule::unique('footers')->ignore($this->footer->id),
            ],
            'link' => 'url',
        ]);

        $this->footer->update($data);

        $this->success(__('Footer updated with success.'), redirectTo: '/admin/footers/index');
    }

}; ?>

<div>
    <x-card class="" title="{{__('Edit a footer')}}">
 
        <x-form wire:submit="save"> 
            <x-input label="{{__('Title')}}" wire:model="label" />
            <x-input type="text" wire:model="link" label="{{ __('Link') }}" />   
            <x-slot:actions>
                <x-button label="{{__('Cancel')}}" icon="o-hand-thumb-down" class="btn-outline" link="/admin/footers/index" />
                <x-button label="{{__('Save')}}" icon="o-paper-airplane" spinner="save" type="submit" class="btn-primary" />
            </x-slot:actions>
        </x-form>

    </x-card>
</div>