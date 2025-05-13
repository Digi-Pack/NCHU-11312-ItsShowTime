<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Inquiry
 * 
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property int $product_id
 * @property int $quantity
 * @property string|null $remark
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Inquiry extends Model
{
	protected $table = 'inquiries';

	protected $casts = [
		'product_id' => 'int',
		'quantity' => 'int'
	];

	protected $fillable = [
		'user_id',
		'name',
		'email',
		'phone',
		'address',
		'remark',
		'status',
		'mail_message',
		'reply_mail_sent',
		'cancel_mail_sent',
	];

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function orderLists()
	{
		return $this->hasMany(OrderList::class);
	}
}
