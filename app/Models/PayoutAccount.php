<?php

namespace App\Models;

use App\Core\Data\Model;

/**
 * @class PayoutAccount
 * @package Models
 * @project ChalkySticks API
 */
class PayoutAccount extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'payoutaccounts';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['user_id', 'bank_account', 'stripe_recipient_id'];

	// Relationships
	// -----------------------------------------------------------------------

	public function user() {
		return $this->hasOne(User::class, 'id', 'user_id');
	}
}
