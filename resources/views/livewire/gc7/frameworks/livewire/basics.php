<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;

new #[Title('Basics')] #[Layout('components.layouts.gc7.main')] class extends Component {
	public $name = '';

	public function mount()
	{
		$this->name = auth()->user()->name ?? 'Friend !';
	}

	public function sendMail()
	{
		$to      = 'destinataire@example.com'; // Remplacez par l'adresse email du destinataire
		$subject = 'Sujet de l\'email';
		$message = 'Ceci est le contenu de l\'email.';
		$headers = 'From: expediteur@example.com' . "\r\n" .
				   'Reply-To: expediteur@example.com' . "\r\n" .
				   'X-Mailer: PHP/' . phpversion();

		// Envoyer l'email
		if (mail($to, $subject, $message, $headers)) {
			echo 'Email envoyé avec succès.';
		} else {
			echo 'Échec de l\'envoi de l\'email.';
		}
	}
};
