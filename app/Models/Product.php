<?php

namespace App\Models;

use App\Core\Data\Model;

/**
 * @class Product
 * @package Models
 * @project ChalkySticks API
 */
class Product extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'products';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'sku',
		'amount',
		'currency', // 'USD', 'CSX', etc. CSX = ChalkySticks xChange
		'brand_name', 'product_name', 'description', 'long_description',
		'for_sale', 'for_display',
	];
}
