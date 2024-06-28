<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new #[Title('Divers')] #[Layout('components.layouts.gc7.main')] class extends Component {}; ?>

<div>
    <x-header title="Divers" shadow separator progress-indicator></x-header>

    <p id="p1" @click="console.log($event)">Ready.</p>


    <div class="flex w-full max-w-xl text-center flex-col gap-1">
        <span class="w-fit pl-0.5 text-sm text-slate-700 dark:text-slate-300">Cover Picture</span>
        <div
            class="flex w-full flex-col items-center justify-center gap-2 rounded-xl border-2 border-dashed border-slate-300 p-8 text-slate-700 dark:border-slate-700 dark:text-slate-300 dark:bg-base-300">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" fill="currentColor"
                class="w-12 h-12 opacity-75">
                <path fill-rule="evenodd"
                    d="M10.5 3.75a6 6 0 0 0-5.98 6.496A5.25 5.25 0 0 0 6.75 20.25H18a4.5 4.5 0 0 0 2.206-8.423 3.75 3.75 0 0 0-4.133-4.303A6.001 6.001 0 0 0 10.5 3.75Zm2.03 5.47a.75.75 0 0 0-1.06 0l-3 3a.75.75 0 1 0 1.06 1.06l1.72-1.72v4.94a.75.75 0 0 0 1.5 0v-4.94l1.72 1.72a.75.75 0 1 0 1.06-1.06l-3-3Z"
                    clip-rule="evenodd" />
            </svg>
            <div class="group">
                <label for="fileInputDragDrop"
                    class="cursor-pointer font-medium text-blue-700 group-focus-within:underline dark:text-blue-600">
                    <input id="fileInputDragDrop" type="file" class="sr-only" aria-describedby="validFileFormats" />
                    Browse
                </label>
                or drag and drop here
            </div>
            <small id="validFileFormats">PNG, JPG, WebP - Max 5MB</small>
        </div>
    </div>


</div>
