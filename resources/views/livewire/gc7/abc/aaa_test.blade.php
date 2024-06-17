<?php
include_once 'aa_test.php';
?>

<div>

    {{-- <livewire:gc7.abc.sqlite /> --}}
    
    {{-- <livewire:todo /> --}}
    <livewire:gc7.abc.livewire />
    {{-- <livewire:gc7.abc.alpinejs.alpine /> --}}
    
    {{-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx --}}
    {{-- <x-partials.gc7.helpers.uuu name='Lionel'/> --}}
    {{-- <x-partials.gc7.helpers.form-textarea :postId=$postId title='TheTitle' placeholder='ThePlaceHolder' cancelBtn=1 /> --}}

    {{-- 
    <x-partials.helpers.textareahelper postId=5 action='createComment' $title='Leave a comment' placeholder='Your comment' /> --}}

    {{-- <livewire:helpers.form-textarea :postId=$postId id=222 action='updateComment' title='Update your comment' cancelBtn=True />
    <livewire:helpers.form-textarea :postId=$postId id=333 action='createAnswer' title='Your answer' placeholder='Your answer' cancelBtn=True />
    <livewire:helpers.form-textarea :postId=$postId id='444' action='updateAnswer' title='Update your comment' cancelBtn=True /> --}}
    {{-- <livewire:gc7.abc.uuu lastname='Côte'/> --}}
    {{-- <livewire:gc7.helpers.form-textarea /> --}}
    {{-- <livewire:gc7.abc.alpine /> --}}

    {{-- Appel counter --}}
    {{-- Counter: --}}
    {{-- <livewire:gc7.abc.mains.counter :num="777" :count="777" /> --}}
    {{-- <x-helpers.form-textarea charsNbLeft="12" /> --}}

    {{-- <livewire: gc7.abc.mains.counter :n=7 " /> --}}

    {{-- <hr class="my-5"> --}}

    {{-- <x-partials.abc.counterbox :num=777 :count=100 /> --}}
    {{-- BEST SOLUTION
    <div x-data="{ name: '{{ $name }}' }">
        <x-input type="text" wire:model='name' x-on:input="name = $event.target.value" />
        <p>Characters Count:<br>
            <span x-text="name.length"></span>
        </p>
    </div> 
    --}}
    {{-- <div x-data="{ name: '{{ $name }}' }">
        <x-input type="text" wire:model='name' x-on:input="name = $event.target.value" />
        <p>Characters Count<br>
            </span> <span x-text="name.length"></span> pour <span x-text="name">
        </p>
    </div>
    <hr>
    {{ $name }}
    <hr>
    {{ trans_choice('uuu :n', 10, ['n' => 100]) }}
    <hr> --}}
    @php
        // $nb2 = env('APP_MAX_NUMBER_OF_CHARS_IN_COMMENTS_FORM', 700);
    @endphp
    {{-- <x-gc7.helpers.form-textarea :charsNbLeft= 55 /> --}}
    {{-- <x-gc7.helpers.form-textarea :charsNbLeft= 77 /> --}}
    {{-- <x-gc7.sql /> --}}
</div>
