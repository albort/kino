<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'series';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'description', 'genre'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['id', 'updated_at', 'created_at'];

	public function seasons(){
		return $this->hasMany('App\SerieSeason');
	}
}