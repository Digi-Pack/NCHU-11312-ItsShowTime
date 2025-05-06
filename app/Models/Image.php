<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Image
 * 
 * @property int $id
 * @property string $img_url
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Image extends Model
{
	protected $table = 'images';

	protected $fillable = [
		'img_name',
		'img_path',
		'isMain',
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
