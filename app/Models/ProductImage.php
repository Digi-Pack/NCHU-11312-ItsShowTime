<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductImage
 * 
 * @property int $id
 * @property int $product_id
 * @property string $img_path
 * @property bool $isMain
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class ProductImage extends Model
{
	protected $table = 'product_images';

	protected $casts = [
		'product_id' => 'int',
		'isMain' => 'bool'
	];

	protected $fillable = [
		'product_id',
		'img_path',
		'isMain'
	];

	public function product()
	{
		return $this->belongsTo(Product::class);
	}
}
