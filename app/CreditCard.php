<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CreditCard extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'credit_cards';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['user_id', 'company', 'creditcard_number', 'expiration_date', 'security_code'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['id', 'expiration_date', 'security_code', 'updated_at', 'created_at'];

	public function user(){
		return $this->belongsTo('App\User');
	}
}