<?php
include_once 'new-form.php';
?>

<div>

    @php
        $maxChars = env('APP_MAX_NUMBER_OF_CHARS_IN_COMMENTS_FORM');
    @endphp

    <x-header title="New Form" shadow separator progress-indicator>
    </x-header>
    
    {{-- DOC --}}
    {{--
    <div x-data="{ count: {{ $maxChars }} }">
        <span x-text="count"></span>
        <x-button class='btn-primary ml-3' x-on:click="count++">Add</x-button>
    </div>
    Current title: <span x-text="$wire.title.toUpperCase()"></span> 
    <x-button class='btn-primary ml-3' x-on:click="$wire.title=''">Clear title</x-button>
    <x-button type="button" class='btn-primary ml-3' x-on:click="$wire.save()">Submit form</x-button>
    --}}

    <form wire:submit="save">

        <label for="title">
            <span>Title</span>
            <x-input class="mt-1 mb-2" type="text" wire:model='title'></x-input>
        </label>

        <label for="content">
            <span>Content</span>
            <x-textarea class="mt-1" name="" id="" cols="30" rows="7" wire:model='content'
                maxlength="{{ $maxChars }}"></x-textarea>
        </label>
        <div class="text-right italic">
            <small>Characters: <span x-text="$wire.content.length + ' / ' + {{ $maxChars }}"></span> -
                Words: <span x-text="$wire.content.split(' ').length -1"></span>
            </small>
        </div>

        <div class="text-right w-full">
            <x-button type="submit" class="btn-primary mt-2 mr-5">Save</x-button>
        </div>
    </form>
</div>
