<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UsersInfo
 * 
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property int|null $phone_number
 * @property string $email
 * @property string|null $img_path
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class UsersInfo extends Model
{
	protected $table = 'users_info';

	protected $casts = [
		'user_id' => 'int',
		'phone_number' => 'int'
	];

	protected $fillable = [
		'user_id',
		'name',
		'phone_number',
		'email',
		'img_path'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}
}
