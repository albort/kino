<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'orders';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['user_id', 'credit_card', 'total', 'status'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['id', 'updated_at', 'created_at'];

	public function user(){
		return $this->belongsTo('App\User');
	}

	public function items(){
		return $this->hasMany('OrderItem');
	}
}