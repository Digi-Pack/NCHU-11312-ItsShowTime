<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderList
 * 
 * @property int $id
 * @property int $inquiry_id
 * @property string $product
 * @property string $color
 * @property string $type
 * @property string $size
 * @property int $quantity
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class OrderList extends Model
{
	protected $table = 'order_lists';

	protected $casts = [
		'inquiry_id' => 'int',
		'quantity' => 'int'
	];

	protected $fillable = [
		'inquiry_id',
		'product_id',
		'product',
		'color',
		'type',
		'size',
		'quantity'
	];

	public function inquiry()
	{
		return $this->belongsTo(Inquiry::class);
	}

	// public function product()
	// {
	// 	return $this->belongsTo(Product::class, 'product_id');
	// }
	public function product()
	{
    return $this->belongsTo(Product::class);
	}
}
