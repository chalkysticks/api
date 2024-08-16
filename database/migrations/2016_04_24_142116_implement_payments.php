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
		Schema::create('payoutaccounts', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id');
			$table->string('bank_account');
			$table->string('stripe_recipient_id');
			$table->timestamps();

			$table->index(['user_id']);
		});

		Schema::create('transactions', function (Blueprint $table) {
			$table->increments('id');
			$table->enum('type', ['digital-product', 'gamble', 'merchandise', 'chalkysticks-fees', 'tournament', 'other'])->default('other');
			$table->integer('type_id');
			$table->enum('status', ['payment', 'refund', 'cancelled']);
			$table->decimal('amount', 8, 2)->default(0);
			$table->enum('currency', ['CSX', 'USD'])->default('CSX');
			$table->integer('user_id');
			$table->string('user_name');
			$table->string('user_email');
			$table->string('stripe_card_token');
			$table->string('stripe_charge_id');
			$table->string('stripe_transaction_id');
			$table->string('cc_name');
			$table->string('cc_digits');
			$table->integer('cc_month');
			$table->integer('cc_year');
			$table->string('notes');
			$table->timestamps();

			$table->index(['type', 'status']);
			$table->unique(['type_id', 'user_id', 'status']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		//
	}
};
