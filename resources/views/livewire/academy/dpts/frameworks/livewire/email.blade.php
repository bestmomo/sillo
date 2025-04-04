<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024.
 */

use App\Mail\MyEmail;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new #[Layout('components.layouts.academy')] class extends Component {
    use Toast;

    public bool $dev;
    public bool $isLocalMailServerRunning;
    public $name = '';
    public $to = 'Tartempion@example.com';
    public $subject = 'Salut !';
    public $content = 'Tatati...';
    public $emailSubject = '';
    public $emailContent = '';
    public $message = '';

    public function mount()
    {
        $this->dev = config('app.env') === 'dev';
        $this->isLocalMailServerRunning = $this->isLocalMailServerRunning();
        // dump('DEV : ' . $this->tf($this->dev), 'LocalMailServer : ' . $this->tf($this->isLocalMailServerRunning));

        $this->name = auth()->user()->name ?? 'Friend !';
        $this->sendMail();
    }
    public function tf($b)
    {
        return $b ? 'true' : 'false';
    }
    public function isLocalMailServerRunning($url = 'http://localhost:8025')
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);

        curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $httpcode >= 100 && $httpcode < 600;
    }
    public function refresh()
    {
        $this->success('Livewire block refreshed');
    }

    public function sendMail()
    {
        
        if ($this->dev)
        { if (!$this->isLocalMailServerRunning) {
                $this->message = '<div class="mt-2 text-yellow-400 text-xl font-new text-center font-bold">Please start a local mail server (Listening on port #1025)&nbsp;!</div>';
                $this->error('Unable to send email ! Local Mail Server is not running');
            } else {
                try {
                    $email = new MyEmail($this->subject, $this->content, $this->name);

                    // dd($email);
                    // Capture le contenu de l'email
                    $this->emailSubject = $email->sujet;
                    $this->emailContent = $email->render();

                    // Envoie l'email
                    if ($this->dev) {
                        Mail::to($this->to)->send($email);
                    }

                    $this->message = 'Email sent successfully!';

                    $this->success('Refresh all and email re-sent successfully!');
                    // $this->reset(['destinataire', 'sujet', 'contenu']);
                } catch (Exception $e) {
                    $possibleCase = '';

                    if (false !== strpos($e, 'Unable to connect to localhost:1025')) {
                        $possibleCase = '<div class="mt-2 text-orange-400 italic text-center font-new text-xl font-bold">Are you sure MailHog, MailPit or other is running on port #1025?</div>';
                    }

                    $this->message = '<div class="mb-3 text-red-500 text-xl font-bold">Sending email error:</div>' . $e->getMessage() . $possibleCase;
                    // . $e->getTraceAsString();
                    
                    $this->error('Unable to send email ! Probably local Mail Server is not running...');
                }
            }
        }
    }

    public function sendMailOnly()
    {
        $this->sendMail();
        // $this->success('Email re-sent successfully!');
        $this->skipRender();
    }
}; ?>

<div class='mx-6'>
    <livewire:academy.components.page-title title='Envoi Emails' />
    <x-header shadow separator progress-indicator />

    <div>
        @if (!$dev)
            <h2 class="text-center text-red-500 text-xl font-bold">Envoi des emails simulé</h2>
        @endif

        @if (!empty($notifications))
            <div id="notifications" wire:ignore></div>
        @endif
    </div>

    @if ($message == 'Email sent successfully!')
        <p class="text-green-400 font-bold">{!! $message !!}</p>
        <b>Here's the preview (HTML):</b>
        <p>Subject: <b>{{ $emailSubject }}</b></p>
        <div class="border p-5 rounded-lg mt-3">
            {!! $emailContent !!}
        </div>
        <span class='text-right'>You can see it too on: <a class="link" href="http://localhost:8025"
                target="_blank"><b>http://localhost:8025</b></a> <x-ext-link /> <i>(If
                you run MailHog or other (on port 1025)...)</i></span>
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

    <x-header class="pb-0 mb-[-14px]" shadow separator progress-indicator />

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
                    <x-button wire:click='sendMail' class='btn-primary btn-sm w-full'>Refresh all &<br>
                        Resend email</x-button>
                </td>
            </tr>
        </tbody>
    </table>

    @php
        echo 'Mode ' . ($dev ? ' dev' : ' prod');
    @endphp

</div>
