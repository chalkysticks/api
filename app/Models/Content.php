<?php

namespace App\Models;

use App\Core\Data\Model;
use Illuminate\Database;

/**
 * @class Content
 * @package Models
 * @project ChalkySticks API
 */
class Content extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'content';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['title', 'media_type', 'media_url', 'thumbnail_url', 'content', 'created_at', 'updated_at'];

	// Scopes
	// -----------------------------------------------------------------------

	/**
	 * @param Database\Query\Builder  $query
	 * @param array $tags
	 * @return mixed
	 */
	public function scopeTags(Database\Query\Builder $query, array $tags = []) {
		return $query->join('content_tags', 'content.id', '=', 'content_tags.content_id')
			->whereIn('content_tags.tag', $tags)
			->select('content.*');
	}

	// Relationships
	// ----------------------------------------------------------------------

	public function tags() {
		return $this->hasMany(ContentTag::class, 'content_id', 'id');
	}
}
