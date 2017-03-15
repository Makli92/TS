<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = ['id', 'street', 'streetnumber', 'phonenumber', 'postcode', 'city', 'country', 'latitude', 'longitude'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
	protected $hidden   = ['created_at', 'updated_at'];

}