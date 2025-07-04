<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Size
 * 
 * @property int $id
 * @property string $size_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Size extends Model
{
	protected $table = 'sizes';

	protected $fillable = [
		'size_name',
		'sort_order',
	];

	public function product()
	{
		return $this->belongsTo(Product::class, 'id');
	}

	public function productsinfo()
	{
		return $this->belongsTo(Productsinfo::class, 'id');
	}
}
