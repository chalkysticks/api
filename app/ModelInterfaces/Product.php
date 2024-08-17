<?php

namespace App\ModelInterfaces;

use App\Core\Data\ModelInterface;

/**
 * @class Product
 * @package ModelInterfaces
 * @project ChalkySticks API
 */
class Product extends ModelInterface {
	/**
	 * @return array
	 */
	public function transform($model) {
		return [
			'id' => $model->id,
			'sku' => (string) $model->sku,
			'amount' => $model->amount,
			'currency' => (string) $model->currency,
			'brand_name' => (string) $model->brand_name,
			'product_name' => (string) $model->product_name,
			'description' => (string) $model->description,
			'long_description' => (string) $model->long_description,
			'for_sale' => (bool) $model->for_sale,
			'for_display' => (bool) $model->for_display,
		];
	}
}
