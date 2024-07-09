<?php
include_once 'basics.php';
?>

<div>
    <x-header class="pb-0 mb-[-14px]" title="Basics" shadow separator progress-indicator />

    <div>
        <!-- Votre contenu existant -->

        @if (!empty($this->notifications))
            <div id="notifications" wire:ignore></div>
        @endif
    </div>


    @if ($this->message == 'Email sent successfully!')
        <p class="text-green-400 font-bold">{!! $message !!}</p>
        <b>Here's the preview (HTML):</b>
        <p>Subject: <b>{{ $emailSubject }}</b></p>
        <div class="border p-5 rounded-lg mt-3">
            {!! $emailContent !!}
        </div>
        You can see it too on: <a class="link" href="http://localhost:8025" target="_blank">http://localhost:8025</a> (If
        you've run MailHog...)
    @else
        <p class="text-red-400 font-bold">{!! $message !!}</p>
    @endif

    <hr class="mt-7 mb-3">

    <div class="text-blue-500">
        <h2>Hello World, <b>{{ $name }}</b>!</h2>
        <hr>
        The current time is {{ time() }} seconds since 01/01/1970.<br>
        The complete current date is <b>{{ date('Y-m-d H:i:s', time()) }}</b>.
    </div>

    <x-header class="pb-0 mb-[-14px]" title="" shadow separator progress-indicator />
    <table>
        <thead>
            <th>
                Note
            </th>
            <th>Action</th>
        </thead>
        <tbody>
            <tr>
                <td>
                    This refresh button only works<br>
                    for the livewire block (Above in blue)
                </td>
                <td>
                    <x-button wire:click='refresh' class='btn-primary btn-sm w-full'>Refresh</x-button>
                </td>
            </tr>
            <tr>
                <td>This only re-send the email (Without refresh)</td>
                <td>
                    <x-button wire:click='sendMailOnly' class='btn-primary btn-sm w-full'>Resend email</x-button>
                </td>
            </tr>
            <tr>
                <td>This last button do the 2 actions</td>
                <td>
                    <x-button wire:click='sendMail' class='btn-primary btn-sm w-full'>Refresh &<br>
                        Resend email</x-button>
                </td>
            </tr>
        </tbody>
    </table>


</div>

</div>
</div>
