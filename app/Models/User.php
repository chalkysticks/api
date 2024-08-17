<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Core\Data\DistanceModel;
use App\Core\Data\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Intervention\Image\Facades\Image;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * @class User
 * @package Models
 * @project ChalkySticks API
 */
class User extends Model implements JWTSubject {
	use DistanceModel;
	use HasFactory, Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'name',
		'email',
		'password',
		'slug',
		'lat',
		'lon',
		'phone'
	];

	/**
	 * The attributes that should be hidden for serialization.
	 *
	 * @var array<int, string>
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];

	/**
	 * Map things differently?
	 *
	 * @var array
	 */
	protected $mappingProperties = array(
		'name' => [
			'type' => 'string',
			"analyzer" => "standard",
		],
		'email' => [
			'type' => 'string',
			"analyzer" => "standard",
		],
		'location' => [
			'type' => 'geo_point',
			"analyzer" => "standard"
		],
	);

	/**
	 * Get the attributes that should be cast.
	 *
	 * @return array<string, string>
	 */
	protected function casts(): array {
		return [
			'email_verified_at' => 'datetime',
			'password' => 'hashed',
		];
	}

	// Core
	// -------------------------------------------------------------------------

	public function purge($include_me = false) {
		$urls = [
			'/v1/users/' . $this->id . '/',
			'/v1/users/' . $this->id . '/.*'
		];

		if ($include_me) {
			$urls[] = '/v1/me';
			$urls[] = '/v1/me/*';
		}

		// @todo re-enable this
		// Queue::push(new \App\Jobs\PurgeURLs($urls));
	}

	// Serialization
	// -------------------------------------------------------------------------

	/**
	 * Get the identifier that will be stored in the JWT subject claim.
	 *
	 * @return mixed
	 */
	public function getJWTIdentifier() {
		return $this->getKey();
	}

	/**
	 * Return a key-value array, containing any custom claims to be added to the JWT.
	 *
	 * @return array
	 */
	public function getJWTCustomClaims() {
		return [];
	}

	// Relationships
	// -------------------------------------------------------------------------

	public function accomplishments() {
		return $this->hasMany(UserAccomplishment::class, 'user_id', 'id');
	}

	public function beacons() {
		return $this->hasMany(Beacon::class, 'user_id', 'id');
	}

	public function checkins() {
		return $this->hasMany(VenueCheckin::class, 'user_id', 'id')->orderBy('created_at', 'desc');
	}

	public function innings() {
		return $this->hasMany(GameInning::class, 'user_id', 'id');
	}

	public function media() {
		return $this->hasMany(UserMedia::class, 'user_id', 'id');
	}

	public function meta() {
		return $this->hasMany(UserMeta::class, 'user_id', 'id');
	}

	public function paymentAccount() {
		return $this->hasOne(UserPaymentAccount::class, 'user_id', 'id');
	}

	public function profile() {
		return $this->hasMany(UserMeta::class, 'user_id', 'id')->where('group', 'profile');
	}

	public function gamesPreferred() {
		return $this->hasMany(UserMeta::class, 'user_id', 'id')->where('group', 'games');
	}

	public function pushNotify() {
		return $this->hasMany(UserMeta::class, 'user_id', 'id')->where('group', 'push_notify');
	}

	public function prizes() {
		return $this->hasMany(UserPrize::class, 'user_id', 'id')->orderBy('created_at', 'desc');
	}

	public function products() {
		return Transaction::select('products.*')
			->leftJoin('products', 'products.id', '=', 'transactions.type_id')
			->where('transactions.user_id', $this->id)
			->orderBy('created_at', 'DESC');
	}

	public function teams() {
		return $this->hasMany(Team::class, 'owner_id', 'id');
	}

	public function transactions() {
		return $this->hasMany(Transaction::class, 'user_id', 'id');
	}

	public function wallet() {
		return $this->hasMany(UserWallet::class, 'user_id', 'id')->orderBy('created_at', 'desc');
	}

	public function scopeGames($query) {
		return $query->where('user1_id', '=', $this->id)->orWhere('user2_id', '=', $this->id);
	}

	public function getMatches($query) {
		return $query->where('user1_id', '=', $this->id)->orWhere('user2_id', '=', $this->id);
	}
	// Getters
	// -------------------------------------------------------------------------

	public function friends() {
		return $this->belongsToMany(User::class, 'user_friends', 'user_id', 'friend_id')
			->wherePivot('status', 'approved');
	}

	public function friendRequests() {
		return $this->belongsToMany(User::class, 'user_friends', 'friend_id', 'user_id')
			->wherePivot('status', 'pending');
	}

	public function hasPayment($type_id) {
		return $this->hasOne(Transaction::class, 'user_id', 'id')->where('type_id', $type_id)->exists();
	}

	public function isFriendsWith($friend) {
		return UserFriend::where(function ($q) use ($friend) {
			$q->where('user_id', $this->id)->where('friend_id', $friend->id);
		})
			->orWhere(function ($q) use ($friend) {
				$q->where('user_id', $friend->id)->where('friend_id', $this->id);
			})
			->count() >= 1;
	}

	public function lastCollection() {
		return $this->wallet->where('source', 'collection')->first();
	}

	public function walletBalance() {
		return $this->wallet->sum('transaction');
	}

	// Actions
	// -------------------------------------------------------------------------

	/**
	 * If the user is an admin
	 *
	 * @return bool
	 */
	public function isAdmin() {
		return $this->id === 1 || $this->email === 'matt@chalkysticks.com';
	}

	/**
	 * Check if a user can do something
	 *
	 * @param string $permission
	 * @return bool
	 */
	public function can(string $permission): bool {
		$permissions = json_decode($this->permissions);

		if (isset($permissions) && is_array($permissions)) {
			// super admin goes through everything
			if (in_array('super-admin', $permissions)) {
				return true;
			}

			// specific permission
			if (in_array($permission, $permissions)) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Create a new beacon based off this user
	 *
	 * @param float $lat
	 * @param float $lon
	 * @param bool $keepalive
	 * @return \App\Models\Beacon
	 */
	public function setBeacon(float $lat, float $lon, bool $keepalive = true): Beacon {
		$model = Beacon::create([
			'keepalive' => $keepalive,
			'lat' => $lat,
			'lon' => $lon,
			'status' => 'active',
			'user_id' => $this->id,
		]);

		return $model;
	}

	/**
	 * Disable all beacons for this user
	 *
	 * @return void
	 */
	public function disableBeacons() {
		foreach ($this->beacons as $beacon) {
			$beacon->status = 'inactive';
			$beacon->save();
		}
	}

	/**
	 * Add meta data for the user
	 *
	 * @param string $group
	 * @param string $key
	 * @param string $value
	 * @return UserMeta
	 */
	public function addMeta(string $group = '', string $key = 'foo', string $value = ''): UserMeta {
		$meta = $this->meta->where('group', $group)->where('key', $key)->first();

		if ($meta && $meta->id) {
			$meta->value = $value;
			$meta->save();
		} else {
			$meta = UserMeta::create([
				'group' => $group,
				'key' => $key,
				'user_id' => $this->id,
				'value' => $value,
			]);
		}

		return $meta;
	}

	/**
	 * Add game meta data for the user
	 *
	 * @param string $group
	 * @param string $key
	 * @param string $value
	 * @return UserMeta
	 */
	public function addGamesMeta(string $key = 'foo', string $value = ''): UserMeta {
		$meta = $this->gamesPreferred->where('key', $key)->first();

		if ($meta && $meta->id) {
			$meta->value = $value;
			$meta->save();
		} else {
			$meta = UserMeta::create([
				'group' => 'games',
				'key' => $key,
				'user_id' => $this->id,
				'value' => $value,
			]);
		}

		return $meta;
	}

	/**
	 * Add profile meta data for the user
	 *
	 * @param string $key
	 * @param string $value
	 * @return UserMeta
	 */
	public function addProfileMeta(string $key = 'foo', string $value = ''): UserMeta {
		return $this->addMeta('profile', $key, $value);
	}

	/**
	 * @todo
	 *
	 * @param mixed $file
	 * @return void
	 */
	public function addImage($file) {
		// // open and resize an image file
		// $filename = 'user-photo-' . $this->id . '-' . rand(0, 9999) . '.' . $file->getClientOriginalExtension();
		// $filepath = storage_path() . '/app/' . $filename;

		// $img = Image::make($file)->resize(null, 600, function ($constraint) {
		// 	$constraint->aspectRatio();
		// })->orientate();

		// $img->save($filepath, 80);

		// // aws upload
		// $s3 = AWS::get('s3');
		// $response = $s3->putObject(array(
		// 	'Bucket' => 'chalkysticks-cms',
		// 	'Key' => $filename,
		// 	'SourceFile' => $filepath,
		// 	'ACL' => 'public-read'
		// ));

		// $model = UserMedia::create([
		// 	'user_id' => $this->id,
		// 	'type' => 'image',
		// 	'url' => $response->get('ObjectURL')
		// ]);

		// // delete local file
		// @unlink($filepath);

		// return $model;
	}

	// Static Override
	// ----------------------------------------------------------------------

	/**
	 * Get a user from an JWT
	 *
	 * @return \App\Models\User|null
	 */
	public static function fromJWT(): User|null {
		try {
			JWTAuth::parseToken('bearer', 'authorization-api');
			$token = JWTAuth::getToken();
			$user = JWTAuth::toUser($token);
		} catch (JWTException $e) {
			return null;
		}

		return $user;
	}
}
