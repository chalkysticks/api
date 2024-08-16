<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class UsersMediaTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table('usersmedia')->insert([
			'user_id' => 1,
			'type' => 'image',
			'url' => 'https://scontent-lga3-1.xx.fbcdn.net/hphotos-xpf1/v/t1.0-9/76148_532179582016_7299445_n.jpg?oh=8e24be30d32ba92bfa8330450fea9518&oe=5738E98C'
		]);

		DB::table('usersmedia')->insert([
			'user_id' => 2,
			'type' => 'image',
			'url' => 'https://scontent-lga3-1.xx.fbcdn.net/hphotos-xlf1/v/t1.0-9/996753_10153912561802948_4693900684942451412_n.jpg?oh=6c2ff1131f4144446d0898be5d836deb&oe=574965EF'
		]);

		DB::table('usersmedia')->insert([
			'user_id' => 3,
			'type' => 'image',
			'url' => 'https://scontent-lga3-1.xx.fbcdn.net/hphotos-xap1/v/t1.0-9/12376169_10156269613095627_6375300864395095315_n.jpg?oh=75964aa03e7f76a2371b78dacc84acd4&oe=5748503D'
		]);

		DB::table('usersmedia')->insert([
			'user_id' => 4,
			'type' => 'image',
			'url' => 'https://scontent-lga3-1.xx.fbcdn.net/hphotos-xtl1/v/t1.0-9/11061281_10207123597870968_6626413648113203729_n.jpg?oh=58e299614f448c6a4760c4984b8d3606&oe=57470708'
		]);

		DB::table('usersmedia')->insert([
			'user_id' => 5,
			'type' => 'image',
			'url' => 'https://scontent-lga3-1.xx.fbcdn.net/hphotos-xpt1/v/t1.0-9/10689834_10152538874962893_1350429688726406869_n.jpg?oh=8f507659eff675956c9eb602b082ae86&oe=570131CC'
		]);

		DB::table('usersmedia')->insert([
			'user_id' => 6,
			'type' => 'image',
			'url' => 'http://i.imgur.com/YQuH9.png'
		]);

		DB::table('usersmedia')->insert([
			'user_id' => 7,
			'type' => 'image',
			'url' => 'https://scontent-lga3-1.xx.fbcdn.net/hphotos-xfl1/t31.0-8/10623778_10153127156472704_8189660300911328237_o.jpg'
		]);

		DB::table('usersmedia')->insert([
			'user_id' => 8,
			'type' => 'image',
			'url' => 'https://pbs.twimg.com/profile_images/653682718333493248/lzxrUiUJ.jpg'
		]);

		DB::table('usersmedia')->insert([
			'user_id' => 9,
			'type' => 'image',
			'url' => 'http://www.thesundaytimes.co.uk/sto/multimedia/dynamic/00207/Time-and-place_207137k.jpg'
		]);

		DB::table('usersmedia')->insert([
			'user_id' => 10,
			'type' => 'image',
			'url' => 'https://scontent-lga3-1.xx.fbcdn.net/hphotos-xlf1/v/t1.0-9/11203044_10204850705258410_3883681409972950920_n.jpg?oh=304330590b73af581b96c8a4f9ce8116&oe=574945A0'
		]);

		DB::table('usersmedia')->insert([
			'user_id' => 11,
			'type' => 'image',
			'url' => 'https://scontent-lga3-1.xx.fbcdn.net/hphotos-xfp1/v/t1.0-9/17803_10153059113282891_5253768176202378494_n.jpg?oh=a032b84e38ce2de465e793f4420b6f57&oe=5704C0EE'
		]);

		DB::table('usersmedia')->insert([
			'user_id' => 12,
			'type' => 'image',
			'url' => 'https://scontent-lga3-1.xx.fbcdn.net/hphotos-xaf1/v/t1.0-9/10407977_10153004655277731_5666696892725982371_n.jpg?oh=edc8e82cd7849bc4d6f258be813c33c1&oe=5742F5A0'
		]);

		DB::table('usersmedia')->insert([
			'user_id' => 13,
			'type' => 'image',
			'url' => 'https://scontent-lga3-1.xx.fbcdn.net/hphotos-xpa1/v/t1.0-9/1357_40380734754_2072_n.jpg?oh=2432dbca90f9a5bbf17b1580f4f74632&oe=5704959F'
		]);

		DB::table('usersmedia')->insert([
			'user_id' => 14,
			'type' => 'image',
			'url' => 'https://scontent-lga3-1.xx.fbcdn.net/hphotos-xpt1/t31.0-8/12187971_10208033018167262_2047802228672105438_o.jpg'
		]);
	}
}
