<?php

namespace App\Models;

use App\Core\Data\Model;
use App\Utilities;

/**
 * @class TvChannel
 * @package Models
 * @project ChalkySticks API
 */
class TvChannel extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tvchannels';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['id', 'youtube_id', 'title', 'description', 'channel_id', 'image_url'];

	/**
	 * @param string $youtubeUrl
	 * @return object|null
	 */
	public static function createFromChannelId(string $channelId): object|null {
		$json = Utilities\YouTube::fetchChannel($channelId);

		// No results, skip
		if ($json->pageInfo->totalResults === 0) {
			return null;
		}

		$item = $json->items[0];
		$data = [
			'title' => $item->snippet->title,
			'description' => $item->snippet->description,
			'channel_id' => $item->snippet->customUrl,
			'image_url' => ($item->snippet->thumbnails->medium ?: $item->snippet->thumbnails->default)->url,
		];

		$model = TvChannel::updateOrCreate(['youtube_id' => $item->id], $data);

		return $model;
	}
}
