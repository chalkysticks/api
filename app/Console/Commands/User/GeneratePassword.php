<?php

namespace App\Console\Commands\User;

use Illuminate\Console\Command;

/**
 * @class GeneratePassword
 * @package Console/Commands/User
 * @project ChalkySticks API
 */
class GeneratePassword extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'user:password {password?}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Creates a user password using hash';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle() {
		$password = $this->argument('password');
		$hash = hash_password($password);

		$this->line($hash);
	}
}
