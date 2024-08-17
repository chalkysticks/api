<?php

namespace App\ModelInterfaces;

use App\Core\Data\ModelInterface;
use App\Models;

/**
 * @class Content
 * @package ModelInterfaces
 * @project ChalkySticks API
 */
class Content extends ModelInterface {
	/**
	 * @var array
	 */
	protected $defaultIncludes = [
		'tags'
	];

	/**
	 * @param Models\Content $model
	 * @return \League\Fractal\Resource\Collection
	 */
	public function includeTags(Models\Content $model) {
		$tags = $model->tags;

		return $this->collection($tags, new Tag);
	}

	/**
	 * @return array
	 */
	public function transform($model) {
		return [
			'id' => $model->id,
			'title' => $model->title,
			'content' => $model->content,
			'media_type' => $model->media_type,
			'media_url' => $model->media_url,
			'thumbnail_url' => $model->thumbnail_url,
			'created_at' => (string) $model->created_at,
			'updated_at' => (string) $model->updated_at,
		];
	}
}
