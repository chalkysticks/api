<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class ContentTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table('content')->insert([
			'id' => 1,
			'title' => "Shane Van Boening runs an 8-pack",
			'media_type' => "video",
			'media_url' => "https://www.youtube.com/embed/Dee4fgxEC68",
			'content' => "Commentators: Daniel Busch, Mark Cantrill, Mike Ayres and Brett Van Voast<br><br>Produced by: Mark Cantrill and Daniel Busch - Legends and Champions Pool Tour and POV Pool<br><br>Directed by: Daniel Busch<br><br>Recorded at The Eagle's Lodge 16 during \"The Decider\" event which took place in August of 2013."
		]);

		DB::table('content')->insert([
			'id' => 2,
			'title' => "Bustamante/Reyes vs Deuel/Dechaine Pt. 3",
			'media_type' => "video",
			'media_url' => "https://www.youtube.com/embed/s0jqC7_Cfqo",
			'content' => "<p>CueSports International presents the OB Challenge; Francisco Bustamante and Efren Reyes vs Corey Deuel and Mike Dechaine in a Scotch Doubles 8 Ball Race to 21. </p><p>This match was recorded July 21, 2014 during the BCAPL &amp; USAPL National Championships at the Rio All-Suite Hotel &amp; Casino in Las Vegas, NV. </p><p>For more in on OB: http://www.obcues.com/</p><p>For more info on CSI: http://playcsipool.com/</p>"
		]);

		DB::table('content')->insert([
			'id' => 3,
			'title' => "Efrey Reyes vs Rafael Martinez",
			'media_type' => "video",
			'media_url' => "https://www.youtube.com/embed/9VQJDbuIb20",
			'content' => "<p>CueSports International presents the OB Challenge; Francisco Bustamante and Efren Reyes vs Corey Deuel and Mike Dechaine in a Scotch Doubles 8 Ball Race to 21. </p><p>This match was recorded July 21, 2014 during the BCAPL &amp; USAPL National Championships at the Rio All-Suite Hotel &amp; Casino in Las Vegas, NV. </p><p>For more in on OB: http://www.obcues.com/</p><p>For more info on CSI: http://playcsipool.com/</p>"
		]);

		DB::table('content')->insert([
			'id' => 4,
			'title' => "Jessica Frideres vs Liz Lovely",
			'media_type' => "video",
			'media_url' => "https://www.youtube.com/embed/tQYC_uye92o",
			'content' => "<p>2015 US Bar Table Championships 8-Ball Division February 20-22, 2015</p><p>Commentator: Ken Shuman and special guests</p>"
		]);

		DB::table('content')->insert([
			'id' => 5,
			'title' => "Florian Kohler with Dude Perfect",
			'media_type' => "video",
			'media_url' => "https://www.youtube.com/embed/IlQnGkfskrQ",
			'content' => ""
		]);

		// -----------------------------------------------------------------------

		DB::table('content')->insert([
			'id' => 6,
			'title' => "Shape on the 9 Ball",
			'media_type' => "image",
			'media_url' => "http://pad.chalkysticks.com/image/e792d",
			'thumbnail_url' => "http://pad.chalkysticks.com/image/e792d",
			'content' => "Use a soft stroke."
		]);

	}
}
