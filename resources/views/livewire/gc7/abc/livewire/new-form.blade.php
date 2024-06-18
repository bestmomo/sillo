<?php
include_once 'new-form.php';
?>

<div>
    <x-header title="New Form" shadow separator progress-indicator>
    </x-header>

    <div x-data="{ count: 7 }">
        <span x-text="count"></span>
        <button x-on:click="count++">Add</button>
    </div>

    Current title: <span x-text="$wire.title.toUpperCase()"></span>

    @php
        $maxChars = env('APP_MAX_NUMBER_OF_CHARS_IN_COMMENTS_FORM');
    @endphp

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

        <div class="text-right w-full">
            <x-button type="submit" class="btn-primary mt-2 mr-5">
                Save</x-button>
        </div>
    </form>
</div>
