<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'cart_items';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['order_id', 'article_id', 'article_type', 'article_amount', 'total'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['id', 'order_id', 'updated_at', 'created_at'];

	public function order(){
		return $this->belongsTo('App\Order');
	}

	public function article(){
		$article_type = $this['article_type'];
		if($article_type == 'movie'){
			return $this->hasOne('App\Movie');
		} else {
			return $this->hasOne('App\SerieSeason')
		}
	}
}