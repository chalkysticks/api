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
		Schema::table('transactions', function (Blueprint $table) {
			$table->dropColumn('type');
			$table->dropColumn('currency');
			$table->dropColumn('amount');
		});


		Schema::table('transactions', function (Blueprint $table) {
			$table->enum('type', ['digital-product', 'gamble', 'merchandise', 'chalkysticks-fees', 'tournament', 'other'])
				->default('other')
				->before('type_id')
				->comment = 'This is the category of purchase to help direct type_id';

			$table->enum('currency', ['CSX', 'USD'])
				->default('CSX')
				->before('user_id')
				->comment = 'CSX is ChalkySticks xChange.';

			$table->decimal('amount', 8, 2)
				->default(0)
				->after('status');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('transactions', function (Blueprint $table) {
			$table->string('type', 100)->change();
			$table->string('currency', 100)->change();
			$table->int('amount', 11)->unsigned()->change();
		});
	}
};
