<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

namespace App\Console\Commands;

use App\Events\MessageSent;
use Illuminate\Console\Command;

class SendMessageCommand extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 * 
	 * php .\artisan reverb:start
	 * En CLI: php .\artisan send:message
	 * Voir Outil de dev, Network (WS) -> Refresh → Response
	 */
	protected $signature = 'send:message';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Send a message to the chat';

	/**
	 * Execute the console command.
	 */
	public function handle()
	{
		// $name = $this->ask('What is your name?');
		// while (empty($name)) {
		// 	$this->error('Name is required.');
		// 	$name = $this->ask('What is your name?');
		// }
		// $text = $this->ask('What is your text?');
		// while (empty($text)) {
		// 	$this->error('Text is required.');
		// 	$text = $this->ask('What is your text?');
		// }

		$name = 'Lionel';
		$text = 'Message: ' . date('Y-m-d H:i:s');

		$this->info($name . ' : ' . $text);

		MessageSent::dispatch($name, $text);
	}
}
