<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductsInfo
 * 
 * @property int $id
 * @property int|null $products_id
 * @property int|null $sizes_id
 * @property int|null $colors_id
 * @property int|null $types_id
 * @property int|null $images_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class ProductsInfo extends Model
{
	protected $table = 'products_info';

	protected $casts = [
		'products_id' => 'int',
		'sizes_id' => 'int',
		'colors_id' => 'int',
		'types_id' => 'int',
		'images_id' => 'int'
	];

	protected $fillable = [
		'product_id',
		'size_id',
		'color_id',
		'type_id',
		'image_id'
	];

	public function product()
{
    return $this->belongsTo(Product::class, 'product_id','id');
}
}
