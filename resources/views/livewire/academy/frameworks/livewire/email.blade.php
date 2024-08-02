<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024.
 */

use App\Mail\MyEmail;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new #[Title('Basics')] #[Layout('components.layouts.academy')]
class extends Component {
	use Toast;

	public $dev;
	public $name         = '';
	public $to           = 'Tartempion@example.com';
	public $subject      = 'Salut !';
	public $content      = 'Tatati...';
	public $emailSubject = '';
	public $emailContent = '';
	public $message      = '';

	public function mount()
	{
		$this->dev  = app()->environment('local');
		$this->name = auth()->user()->name ?? 'Friend !';
		$this->sendMail();
	}

	public function refresh()
	{
		$this->success('Livewire block refreshed');
	}

	public function sendMail()
	{
		try {
			$email = new MyEmail(
				$this->subject,
				$this->content,
				$this->name
			);

			// dd($email);
			// Capture le contenu de l'email
			$this->emailSubject = $email->sujet;
			$this->emailContent = $email->render();

			// Envoie l'email
			if ($this->dev) {
				Mail::to($this->to)->send($email);
			}

			$this->message = 'Email sent successfully!';

			$this->success('Refresh and email re-sent successfully!');

			// $this->reset(['destinataire', 'sujet', 'contenu']);
		} catch (Exception $e) {
			$possibleCase = '';

			if (false !== strpos($e, 'Unable to connect to localhost:1025')) {
				$possibleCase = '<div class="mt-2 text-yellow-500 italic text-center font-bold">Are you sure MailHog is running ?</div>';
			}

			$this->message = '<div class="mb-3">Erreur lors de l\'envoi de l\'email :</div>' . $e->getMessage() . $possibleCase;
			// . $e->getTraceAsString();
		}
	}

	public function sendMailOnly()
	{
		if ($this->dev) {
			$this->sendMail();
		}
		$this->success('Email re-sent successfully!');
		$this->skipRender();
	}
}; ?>

<div>
    <x-header class="pb-0 mb-[-14px]" title="Email" shadow separator progress-indicator />

    <div>
        @if (!$dev)
        <h2 class="text-center text-red-500 text-xl font-bold">Envoi des emails simulé</h2>
        @endif

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
    
    @php
        echo $dev;
    @endphp

</div>
