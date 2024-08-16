<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('products', function (Blueprint $table) {
			$table->increments('id')->unsigned();

			$table->string('sku', 50)->nullable(false);
			$table->enum('type', ['digital', 'physical'])->default('digital');
			$table->enum('currency', ['CSX', 'USD'])->default('CSX');
			$table->decimal('amount', 8, 2)->default(0);

			$table->string('brand_name', 100);
			$table->string('product_name', 100);
			$table->string('description', 255);
			$table->text('long_description');

			$table->boolean('for_sale')->default(true)->comment = 'If we can purchase it.';
			$table->boolean('for_display')->default(true)->comment = 'If we display it at all';

			$table->timestamps();

			// $table->index(['user_id', 'friend_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('products');
	}
};
