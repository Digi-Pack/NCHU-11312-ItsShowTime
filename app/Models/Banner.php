<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Banner
 * 
 * @property int $id
 * @property string $title
 * @property string $img_name
 * @property string $img_path
 * @property int $sort_order
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Banner extends Model
{
	protected $table = 'banners';

	protected $casts = [
		'sort_order' => 'int',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'title',
		'img_name',
		'img_path',
		'sort_order',
		'is_active'
	];
}
