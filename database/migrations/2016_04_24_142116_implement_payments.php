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

		Schema::create('tournamentspaymentoptions', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('tournament_id');
			$table->decimal('price', 10, 2)->default(0);
			$table->string('currency');
			$table->string('name');
			$table->string('description');
			$table->timestamps();

			$table->index(['tournament_id']);
		});

		Schema::create('transactions', function (Blueprint $table) {
			$table->increments('id');
			$table->string('type');
			$table->integer('type_id');
			$table->enum('status', ['payment', 'refund', 'cancelled']);
			$table->integer('amount')->default(0);
			$table->string('currency');
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

		DB::statement("
            ALTER TABLE `tournaments`
            ADD COLUMN `accept_payments` tinyint (1)  DEFAULT 0
            AFTER `begins_at`
        ");

		DB::statement("
            ALTER TABLE `tournaments`
            ADD COLUMN `payoutaccount_id` int(11) unsigned null
            AFTER `accept_payments`
        ");

		DB::statement("
            ALTER TABLE `tournamentsentries`
            ADD COLUMN `transaction_id` int(11) unsigned null
            AFTER `rank`
        ");
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
