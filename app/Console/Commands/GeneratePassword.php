<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * @class GeneratePassword
 * @package Console/Commands
 * @project ChalkySticks API
 */
class GeneratePassword extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'generate:password {--password=}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Creates a password using hash';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle() {
		$password = $this->option('password');
		$hash = hash_password($password);

		$this->line($hash);
	}
}
