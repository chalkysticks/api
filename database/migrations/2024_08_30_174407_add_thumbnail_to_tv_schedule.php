<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Schema::table('tvschedule', function (Blueprint $table) {
			$table->string('thumbnail_url')->nullable()->after('embed_url');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::table('tvschedule', function (Blueprint $table) {
			$table->dropColumn('thumbnail_url');
		});
	}
};
