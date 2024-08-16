<?php

namespace App\Models;

use App\Core\Data\Model;

/**
 * @class UserPaymentAccount
 * @package Models
 * @project ChalkySticks API
 */
class UserPaymentAccount extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'userspaymentaccount';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['user_id', 'stripe_account_id', 'first_name', 'last_name', 'account_holder_type', 'email', 'country', 'currency', 'dob_month', 'dob_day', 'dob_year', 'date', 'ip'];
}
