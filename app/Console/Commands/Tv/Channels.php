<?php

namespace App\Console\Commands\Tv;

use App\Models;
use Illuminate\Console\Command;

/**
 * Save details on the channels we use for TV to the tvchannels table.
 *
 * @class Fetch
 * @package Console/Commands/NeTvws
 * @project ChalkySticks API
 */
class Channels extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'tv:channels';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Get data from the channels we use';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle() {
		$channels = config('chalkysticks.tv.channels');

		foreach ($channels as $channelId) {
			Models\TvChannel::createFromChannelId($channelId);
		}
	}
}
