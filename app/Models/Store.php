<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model{

    protected $table = "stores";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = ['id', 'street', 'street_number', 'phone_number', 'post_code', 'city', 'country', 'latitude', 'longitude'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
	protected $hidden   = ['created_at', 'updated_at', 'pivot'];

    public function staff()
    {
        return $this->belongsToMany('App\Models\User', 'users_to_stores', 'store_id', 'user_id')->select(array('id', 'first_name', 'last_name'));
    }

}