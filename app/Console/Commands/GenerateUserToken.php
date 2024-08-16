<?php
namespace App\Console\Commands;

use App\Models;
use Illuminate\Console\Command;
use JWTAuth;

class GenerateUserToken extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'user:generateToken';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Creates a JWT token for User 1';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle() {
		$user = Models\User::find(1);

		// No user available
		if (!$user) {
			$this->error('User not found');
			return;
		}

		// Generate token
		$token = JWTAuth::fromUser($user);

		$this->line("Token: $token");
	}
}
