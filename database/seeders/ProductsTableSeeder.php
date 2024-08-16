<?php

namespace Database\Seeders;

use App\Enums;
use DB;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		// Digital Trainer Products
		// -------------------------------------------------------------

		DB::table('products')->insert([
			'sku' => 'DG-TRN-cue-generic-01',
			'amount' => 0.00,
			'currency' => Enums\Currency::CSX,
			'brand_name' => Enums\Brands::Generic,
			'product_name' => 'Default',
			'description' => "Don't break too hard with this",
		]);

		DB::table('products')->insert([
			'sku' => 'DG-TRN-chalk-generic-01',
			'amount' => 0.00,
			'currency' => Enums\Currency::CSX,
			'brand_name' => Enums\Brands::Generic,
			'product_name' => 'Default',
			'description' => "This chalky is so old it has grandchalkren that have graduated chalkege.",
		]);

		DB::table('products')->insert([
			'sku' => 'DG-TRN-glove-generic-01',
			'amount' => 0.00,
			'currency' => Enums\Currency::CSX,
			'brand_name' => Enums\Brands::Generic,
			'product_name' => 'Default',
			'description' => "Old trusty. The built-in glove. Your hand.",
		]);


		// Digital Trainer Products - Cues
		// -------------------------------------------------------------

		DB::table('products')->insert([
			'sku' => 'DG-TRN-cue-mccallaugh-01',
			'amount' => 150.00,
			'currency' => Enums\Currency::CSX,
			'brand_name' => Enums\Brands::McCallaugh,
			'product_name' => 'C436s',
			'description' => "<no description>",
		]);

		DB::table('products')->insert([
			'sku' => 'DG-TRN-cue-mccallaugh-02',
			'amount' => 200.00,
			'currency' => Enums\Currency::CSX,
			'brand_name' => Enums\Brands::McCallaugh,
			'product_name' => 'D-Series',
			'description' => "<no description>",
		]);

		DB::table('products')->insert([
			'sku' => 'DG-TRN-cue-mccallaugh-03',
			'amount' => 320.00,
			'currency' => Enums\Currency::CSX,
			'brand_name' => Enums\Brands::McCallaugh,
			'product_name' => 'L-Series',
			'description' => "<no description>",
		]);

		DB::table('products')->insert([
			'sku' => 'DG-TRN-cue-mccallaugh-04',
			'amount' => 315.00,
			'currency' => Enums\Currency::CSX,
			'brand_name' => Enums\Brands::McCallaugh,
			'product_name' => 'Watershed',
			'description' => "<no description>",
		]);

		DB::table('products')->insert([
			'sku' => 'DG-TRN-cue-chalkysticks-01',
			'amount' => 450.00,
			'currency' => Enums\Currency::CSX,
			'brand_name' => Enums\Brands::ChalkySticks,
			'product_name' => 'Fairweather',
			'description' => "<no description>",
		]);

		DB::table('products')->insert([
			'sku' => 'DG-TRN-cue-hunter-01',
			'amount' => 180.00,
			'currency' => Enums\Currency::CSX,
			'brand_name' => Enums\Brands::Hunter,
			'product_name' => 'Venomspreader',
			'description' => "<no description>",
		]);

		DB::table('products')->insert([
			'sku' => 'DG-TRN-cue-bella-01',
			'amount' => 220.00,
			'currency' => Enums\Currency::CSX,
			'brand_name' => Enums\Brands::Bella,
			'product_name' => 'FVK-01',
			'description' => "<no description>",
		]);

		DB::table('products')->insert([
			'sku' => 'DG-TRN-cue-bella-02',
			'amount' => 320.00,
			'currency' => Enums\Currency::CSX,
			'brand_name' => Enums\Brands::Bella,
			'product_name' => 'FVK-02',
			'description' => "<no description>",
		]);


		// Digital Trainer Products - Chalks
		// -------------------------------------------------------------

		DB::table('products')->insert([
			'sku' => 'DG-TRN-chalk-chalkysticks-01',
			'amount' => 20.00,
			'currency' => Enums\Currency::CSX,
			'brand_name' => Enums\Brands::ChalkySticks,
			'product_name' => 'C-Powder',
			'description' => "A special powder and stone blend creates an inexpensive yet reliable contact.",
		]);

		DB::table('products')->insert([
			'sku' => 'DG-TRN-chalk-chalkysticks-02',
			'amount' => 45.00,
			'currency' => Enums\Currency::CSX,
			'brand_name' => Enums\Brands::ChalkySticks,
			'product_name' => 'CS-Powder',
			'description' => "Fine powder and granite allows this chalky to create a solid connection between cue and ball.",
		]);


		// Digital Trainer Products - Gloves
		// -------------------------------------------------------------

		DB::table('products')->insert([
			'sku' => 'DG-TRN-glove-chalkysticks-01',
			'amount' => 0.00,
			'currency' => Enums\Currency::CSX,
			'brand_name' => Enums\Brands::ChalkySticks,
			'product_name' => 'G-Lover',
			'description' => "A special spandex + cotton blend keeps your hand cool and dry for smooth action.",
		]);

	}
}
