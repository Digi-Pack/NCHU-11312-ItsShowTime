<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Type
 * 
 * @property int $id
 * @property string $type_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Type extends Model
{
	protected $table = 'types';

	protected $fillable = [
		'type_name',
		'sort_order',
	];

	public function product()
	{
		return $this->belongsTo(Product::class,'id');
	}

	public function productsinfo()
	{
		return $this->belongsTo(Productsinfo::class, 'id');
	}
}
