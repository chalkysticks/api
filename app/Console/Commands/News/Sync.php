<?php
namespace App\Console\Commands\News;

use App\Jobs;
use App\Models;
// use App\ModelInterfaces;
use Illuminate\Console\Command;
use Queue;

class Sync extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'news:sync {--create=} {--job=}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Sync content from medium';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle() {
		$canCreate = $this->option('create');
		$canJob = $this->option('job');

		$posts = [];
		$url = 'https://medium.com/feed/chalkysticks';
		$content = file_get_contents($url);
		$content = str_replace('content:encoded', 'content', $content);

		// Exit if the XML can't parse
		if (!($x = simplexml_load_string($content))) {
			return;
		}

		// Iterate through items in the feed
		foreach ($x->channel->item as $item) {
			$post = (object) [];
			$post->content = (string) $item->content;
			$post->date = (string) $item->pubDate;
			$post->dateFormat = date('Y-m-d H:i:s', strtotime($item->pubDate));
			$post->images = [];
			$post->link = (string) $item->link;
			$post->title = (string) $item->title;
			$post->ts = strtotime($item->pubDate);

			$doc = new \DOMDocument();
			libxml_use_internal_errors(true);
			$doc->loadHTML($post->content);
			libxml_clear_errors();

			$xpath = new \DOMXPath($doc);
			$src = $xpath->evaluate('string(//img/@src)');

			$post->images[] = $src;

			$posts[] = $post;
		}

		// Iterate through all content
		foreach ($posts as $post) {
			// Get our latest post
			$content = Models\Content::where('created_at', $post->dateFormat)->first();

			// Look for content
			$this->info("Found content ($canCreate / $canJob) $post->title");

			// update
			if (isset($content)) {
				$content->title = $post->title;
				$content->content = $post->content;
				$content->save();
			}

			// Create content and push queue item
			else {
				if ($this->option('create')) {
					$this->info('Creating content: ' . $post->title);

					$model = Models\Content::create([
						'content' => $post->content,
						'created_at' => $post->dateFormat,
						'media_type' => 'image',
						'media_url' => 'https://m.chalkysticks.com/external-logo.png',
						'tags' => 'news',
						'thumbnail_url' => 'https://m.chalkysticks.com/external-logo.png',
						'title' => $post->title,
					]);

					Models\ContentTag::create(array(
						'content_id' => $model->id,
						'tag' => 'news'
					));

					// create a feed item
					if ($this->option('job')) {
						// Queue::push(new Jobs\Feed\ContentAdd($model));
					}
				}
			}
		}
	}
}
