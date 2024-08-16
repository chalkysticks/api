<?php

namespace App\Console\Commands\User;

use App\Models;
use Illuminate\Console\Command;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * @class GenerateToken
 * @package Console/Commands/User
 * @project ChalkySticks API
 */
class GenerateToken extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'user:token {id?}';

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
		$id = $this->argument('id');
		$user = Models\User::find($id);

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
