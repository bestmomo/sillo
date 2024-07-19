<?php

use App\Models\Footer;
use Livewire\Volt\Component;

new class extends Component {
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
        <a href="{{ $footer->link }}" class="mr-1 hover:text-gray-500">
            @lang($footer->label)
        </a>
    @endforeach
    <div>
        -
        <a href="https://github.com/bestmomo/sillo" title="{{ __('Go to the GitHub repository and... Fork it!') }}"
            target="_blank">Version {{ config('app.version') }}</a> © {{ date('Y') }} - <a
            href="https://laravel.sillo.org/laravel-11/" title="{{ __('Go to the actual reference website') }}"
            target="_blank">BestMomo</a>
        @auth
            - <a href="{{ route('admin') }}" title="{{ __('Go to Dashboard') }}">{{ __('Dashboard') }}</a>
        @endauth
    </div>
</footer>
