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
		Schema::create('userspaymentaccount', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->string('stripe_account_id')->nullable();
			$table->string('first_name')->nullable();
			$table->string('last_name')->nullable();
			$table->string('account_holder_type')->nullable();
			$table->string('email')->nullable();
			$table->string('country')->nullable();
			$table->string('currency')->nullable();
			$table->integer('dob_month')->nullable();
			$table->integer('dob_day')->nullable();
			$table->integer('dob_year')->nullable();
			$table->integer('date')->nullable();
			$table->string('ip')->nullable();

			$table->timestamps();

			// $table->index(['user_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('userspaymentaccount');
	}
};
