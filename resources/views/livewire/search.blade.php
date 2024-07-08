<?php

use Livewire\Attributes\Rule;
use Livewire\Volt\Component;

new class() extends Component {
	// Propriété pour le champ de recherche avec validation
	#[Rule('required|string|max:100')]
	public string $search = '';

	/**
	 * Sauvegarde la recherche et redirige vers la page de résultats de recherche.
	 *
	 * @return Illuminate\Http\RedirectResponse
	 */
	public function save()
	{
		$data = $this->validate();

		return redirect('/search/' . $data['search']);
	}
};
?>

<div>
    <!-- Formulaire de recherche -->
    <form wire:submit.prevent="save">
        <x-input 
            placeholder="{{ __('Search') }}..."
            wire:model="search"
            clearable
            icon="o-magnifying-glass"
        />
    </form>
</div>