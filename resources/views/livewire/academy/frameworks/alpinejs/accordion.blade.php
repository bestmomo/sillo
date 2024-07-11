<?php
include_once 'accordion/accordion.php';
?>

<div>
    <style>
        .collapse-arrow>.collapse-title.rotate::after {
            --tw-rotate: -135deg;
        }
    </style>
    @php
        $items = [['Sujet 1', 'Tatati1'], ['Sujet 2', 'Tatati2'], ['Sujet 3', 'Tatati3']];
    @endphp

    <x-header title="Accordion" shadow separator progress-indicator></x-header>

    <p>Dynamic Accordion component:</p>
    <livewire:academy.frameworks.alpinejs.accordion.accordion_items :items=$items />

    <hr>

    <p>AlpineJs Accordion:</p>
    <div class="join join-vertical w-full" x-data="{
        active: 'HeadingOne',
        toggle(item) {
            this.active = item;
            console.log(item, this.active);
            classList = 'text-blue-500';
        }
    }" x-cloak>

        <div x-text="active"></div>
        <div class="collapse collapse-arrow join-item border border-base-300">
            <div class="collapse-title text-xl font-medium" x-on:click="toggle('HeadingOne')" name="my-accordion-4"
                checked=checked :class="{ 'rotate': active === 'HeadingOne' }">
                Click to open this one and close others
            </div>
            <div class='ml-5' :class="{ 'collapse-content': active !== 'HeadingOne' }">
                <p>hello</p>
            </div>
        </div>

        <div class="collapse collapse-arrow join-item border border-base-300" name="my-accordion-4">
            <div class="collapse-title text-xl font-medium" x-on:click="toggle('HeadingTwo')">
                Click to open this one and close others
            </div>
            <div class='ml-5' :class="{ 'collapse-content': active !== 'HeadingTwo' }">
                <p>hello</p>
            </div>
        </div>

        <div class="collapse collapse-arrow join-item border border-base-300">
            <div class="collapse-title text-xl font-medium" x-on:click="toggle('HeadingThree')">
                Click to open this one and close others
            </div>
            <div class='ml-5' :class="{ 'collapse-content': active !== 'HeadingThree' }">
                <p>hello</p>
            </div>
        </div>

    </div>

    <p>DaisyUI accordion:</p>
    @include('livewire.academy.frameworks.alpinejs.accordion.accordion_ori')
    <hr>
</div>
