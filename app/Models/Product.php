<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 * 
 * @property int $id
 * @property string $name
 * @property string $img_path
 * @property string $price
 * @property string $introduction
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Product extends Model
{
	protected $table = 'products';

	protected $fillable = [
		'name',
		'img_path',
		'price',
		'introduction'
	];

	public function color()
	{
		return $this->hasMany(Color::class, 'id');
	}

	public function image()
	{
		return $this->hasMany(Image::class, 'id');
	}

	public function productsinfo()
	{
		return $this->hasMany(ProductsInfo::class, 'product_id', 'id');
	}

	public function size()
	{
		return $this->hasMany(Size::class, 'id');
	}

	public function type()
	{
		return $this->hasMany(Type::class, 'id');
	}

	public function inquiries()
	{
		return $this->hasMany(Inquiry::class);
	}
}
