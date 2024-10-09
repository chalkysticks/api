<?php

namespace App\Console\Commands\Tv;

use App\Utilities;
use Illuminate\Console\Command;

/**
 * Get official ID from a channel
 *
 * @class Fetch
 * @package Console/Commands/NeTvws
 * @project ChalkySticks API
 */
class GetChannelId extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'tv:getchannelid {--id=}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Get channel id from a youtube id';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle() {
		$id = $this->option('id');

		$json = Utilities\YouTube::fetchChannel($id);

		print_r($json);
	}
}
