<x-button x-on:click="choice='{{ $buttonChoice }}'; btnstyle = '{{ $buttonStyle }}'" class="btn-sm btn-primary">
    {{ $buttonText }}
    <span x-text="btnstyle"></span>
</x-button>
<span x-text="choice"></span>
