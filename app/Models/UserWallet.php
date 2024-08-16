<?php

namespace App\Models;

use App\Core\Data\Model;

/**
 * @class UserWallet
 * @package Models
 * @project ChalkySticks API
 */
class UserWallet extends Model {

	const AD_PLAY = 75;
	const GAME = 0;
	const BEACON = 30;
	const PHOTO = 15;
	const DIAGRAM = 130;
	const CHECKIN = 60;
	const TOURNAMENT = 50;
	const SUBMISSION = 200;
	const REVISION = 150;
	const COLLECTION = 75;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'userswallet';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['user_id', 'transaction', 'source', 'source_id', 'created_at', 'updated_at'];


	// Relationships
	// -----------------------------------------------------------------------

	public function challenger() {
		return $this->hasOne(User::class, 'id', 'challenger_id');
	}
}
