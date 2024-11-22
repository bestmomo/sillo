<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MyEmail extends Mailable {
	use Queueable;
	use SerializesModels;

	public $sujet;
	public $contenu;
	public $message;
	public $name;

	public function __construct($sujet, $contenu, $name) {
		$this->sujet   = $sujet;
		$this->contenu = $contenu;
		$this->name    = $name;
	}

	public function build() {
		return $this->subject($this->sujet)
			->view('emails.my-email')
			->with([
				'contenu' => $this->contenu,
				'name'    => $this->name,
			]);
	}
}
