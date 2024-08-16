<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('diagrams', function ($table) {
			$table->integer('ball_count')->after('diagram');
			$table->string('table_type')->after('diagram');
			$table->string('ball_type')->after('diagram');
			$table->text('balls')->after('diagram');
			$table->text('lines')->after('diagram');
			$table->text('texts')->after('diagram');
			$table->text('shapes')->after('diagram');
			$table->text('cues')->after('diagram');
			$table->boolean('is_complete')->after('diagram')->comment('Tests if theres a cueball, lines, and objects. That assumes it might be an articulate diagram.');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('diagrams', function ($table) {
			$table->dropColumn('ball_count');
			$table->dropColumn('table_type');
			$table->dropColumn('ball_type');
			$table->dropColumn('is_complete');

			$table->dropColumn('balls');
			$table->dropColumn('lines');
			$table->dropColumn('texts');
			$table->dropColumn('shapes');
			$table->dropColumn('cues');
		});
	}
};
