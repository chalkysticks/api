<?php

namespace App\Console\Commands\Tv;

use App\Models;
use Illuminate\Console\Command;

/**
 * Check if a URL is still working
 *
 * php artisasn tv:check --all=true
 *
 * Works: https://youtube.com/embed/jkBl_zq3aAI
 * Fails: https://youtube.com/embed/Bv7hZ9e7-T4
 *
 * @class Fetch
 * @package Console/Commands/Tv
 * @project ChalkySticks API
 */
class Check extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'tv:check {youtubeUrl?} {--live=false} {--all=false}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Check if a URL is still operable and can be embedded';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle() {
		$youtubeUrl = $this->argument('youtubeUrl');
		$all = $this->option('all');
		$liveOnly = $this->option('live');

		if ($youtubeUrl) {
			$this->processSingle($youtubeUrl);
		} else if ($liveOnly) {
			$this->processLive();
		} else if ($all) {
			$this->processAll();
		}
	}

	/**
	 * @return void
	 */
	private function processAll() {
		$models = Models\TvSchedule::all();

		// Run through models
		foreach ($models as $model) {
			$this->processSingle($model);
		}
	}

	/**
	 * @return void
	 */
	private function processLive() {
		$models = Models\TvSchedule::where('is_live', true)->get();

		// Run through models
		foreach ($models as $model) {
			$this->processSingle($model);
		}
	}

	/**
	 * @param string $youtubeUrl
	 * @return void
	 */
	private function processSingle(string|Models\TvSchedule $youtubeUrl) {
		if (is_string($youtubeUrl)) {
			$id = parseYoutubeId($youtubeUrl);
			$model = Models\TvSchedule::where('embed_url', "https://youtube.com/embed/$id")->first();
		} else {
			$model = $youtubeUrl;
		}

		// No model available
		if (!$model) {
			$this->error('Model not found');
			return;
		}

		// Everything works fine
		if ($this->testUrl($model->embed_url)) {
			$model->enable();
			$this->info("$model->id is enabled.");
		} else {
			$model->disable();
			$this->warn("$model->id is disabled.");
		}
	}

	/**
	 * @param string $youtubeUrl
	 * @return bool
	 */
	private function testUrl(string $youtubeUrl): bool {
		$id = parseYoutubeId($youtubeUrl);
		$url = "https://www.youtube.com/oembed?url=https://youtube.com/watch?v=$id&format=json";
		$json = fetchJson($url);

		return isset($json->title);
	}
}
