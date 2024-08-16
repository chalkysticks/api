<?php

namespace App\Models;

use App\Core\Data\Model;

/**
 * @class Diagram
 * @package Models
 * @project ChalkySticks API
 */
class Diagram extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'diagrams';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'hash', 'diagram', 'layout', 'version', 'balls',
		'lines', 'texts', 'shapes', 'cues', 'ball_count',
		'is_complete', 'ball_type', 'table_type'
	];

	// Public Methods
	// ----------------------------------------------------------------------

	public function hasPng() {
		return file_exists(storage_path('diagrams/' . $this->hash . '.png'));
	}

	public function hasSvg() {
		return file_exists(storage_path('diagrams/' . $this->hash . '.svg'));
	}

	public function hasImages() {
		return $this->hasPng() && $this->hasSvg();
	}
}
