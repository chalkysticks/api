<?php

namespace App\Models;

use App\Core\Data\Model;

/**
 * @class Transaction
 * @package Models
 * @project ChalkySticks API
 */
class Transaction extends Model {
	const STATUS_PAYMENT = 'payment';
	const STATUS_REFUND = 'refund';
	const STATUS_CANCELLED = 'cancelled';

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'transactions';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'type',
		'type_id',
		'status', // 'payment','refund','cancelled'
		'amount',
		'currency', // 'USD', 'CSX', etc. CSX = ChalkySticks xChange
		'user_id', 'user_name', 'user_email',
		'cc_digits', 'cc_month', 'cc_year',
		'stripe_card_token', 'stripe_charge_id', 'stripe_transaction_id',
		'notes'
	];

	// Override
	// -----------------------------------------------------------------------

	public static function create(array $attributes = array()) {
		// Check for similar purchases first
		$exists = static::where('type', $attributes['type'])
			->where('amount', $attributes['amount'])
			->where('type_id', $attributes['type_id'])
			->where('user_id', $attributes['user_id'])
			->whereRaw('TIMESTAMPDIFF(MINUTE, created_at, NOW()) < 2')
			->first();

		// if we don't have a similar purchase, exit
		if ($exists == 0) {
			return parent::create($attributes);
		} else {
			throw new \Exception('Purchase exists');
		}
	}

	// Relationships
	// -----------------------------------------------------------------------

	public function user() {
		return $this->hasOne(User::class, 'id', 'user_id');
	}
}
