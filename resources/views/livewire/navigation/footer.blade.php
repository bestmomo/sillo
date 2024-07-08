<?php

use App\Models\Footer;
use Livewire\Volt\Component;

new class() extends Component {
	/**
	 * Retourne les données nécessaires à la vue.
	 */
	public function with(): array
	{
		return [
			'footers' => Footer::orderBy('order')->get(),
		];
	}
};
?>

<footer class="flex justify-center text-gray-500 gap-x-2">
    @foreach ($footers as $footer)
        <a href="{{ $footer->link }}" class="mr-2 hover:text-gray-500">
            @lang($footer->label)
        </a>
    @endforeach
    <div>© {{ date('Y') }} - BestMomo</div>
</footer>
