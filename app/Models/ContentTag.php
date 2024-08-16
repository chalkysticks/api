<?php

namespace App\Models;

use App\Core\Data\Model;

/**
 * @class ContentTag
 * @package Models
 * @project ChalkySticks API
 */
class ContentTag extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'content_tags';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['content_id', 'tag'];

	/**
	 * No timestamps on this model
	 */
	public $timestamps = false;
}
