<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class SerieSeason extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'serie_season';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['serie_id', 'season_number', 'episodes', 'director', 'year', 'price'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['id', 'updated_at', 'created_at'];

	public function serie(){
		return $this->belongsTo('App\Serie');
	}

	public function cartItem(){
		return $this->belongsMany('App\CartItem');
	}

	public function orderItem(){
		return $this->belongsMany('App\OrderItem');
	}
}