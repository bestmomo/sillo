<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

use App\Mail\MyEmail;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;

new #[Title('Basics')] #[Layout('components.layouts.gc7.main')] class extends Component {
	public $name         = '';
	public $to           = 'Tartempion@example.com';
	public $subject      = 'Salut !';
	public $content      = 'Tatati...';
	public $emailContent = '';
	public $message = '';

	public function mount()
	{
		$this->name = auth()->user()->name ?? 'Friend !';
		$this->sendMail();
	}

	public function sendMail1()
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

	public function sendMail()
	{
		try {
			$email = new MyEmail($this->subject, $this->content);

			// Capture le contenu de l'email
			$this->emailContent = $email->render();

			// Envoie l'email
			Mail::to($this->to)->send($email);

			$this->message = 'Email sent successfully!';
			// $this->reset(['destinataire', 'sujet', 'contenu']);
		} catch (Exception $e) {
			$this->message = 'Erreur lors de l\'envoi de l\'email : ' . $e->getMessage();
		}
	}
};
