<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Color
 * 
 * @property int $id
 * @property string $color_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Color extends Model
{
	protected $table = 'colors';

	protected $fillable = [
		'color_name'
	];

	public function product()
	{
		return $this->belongsTo(Product::class,'id');
	}
}
