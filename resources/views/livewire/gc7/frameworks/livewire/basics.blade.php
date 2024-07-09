<?php
include_once 'basics.php';
?>

<div>
    <x-header class="pb-0 mb-[-14px]" title="Basics" shadow separator progress-indicator />

    {{ $message }}
    @if ($this->message == 'Email sent successfully!')
        <b>Here's the preview (HTML):</b>
        <div class="border p-5 rounded-lg mt-3">
            {!! $emailContent !!}
        </div>
        You can see it too on: <a class="link" href="http://localhost:8025" target="_blank">http://localhost:8025</a> (If you've run MailHog...)
    @endif

    <hr class="mt-7 mb-3">

    <h2>Hello World, <b>{{ $name }}</b>!</h2>
    <hr>
    The current time is {{ time() }} seconds since 01/01/1970.<br>
    The complete current date is <b>{{ date('Y-m-d H:i:s', time()) }}</b>.
    <hr>
    <div class="text-right mt-3">
        <p class="italic flex">
            (Note: This refresh button is only for the livewire block,<br>not for the sending of email...)
            <x-button wire:click='$refresh' class='btn-primary ml-3'>Refresh</x-button>
        </p>
    </div>

</div>
