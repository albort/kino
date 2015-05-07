<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'movies';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'description', 'director', 'genre', 'year', 'price'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['id', 'updated_at', 'created_at'];

	public function cartItem(){
		return $this->belongsMany('App\CartItem');
	}

	public function orderItem(){
		return $this->belongsMany('App\OrderItem');
	}
}