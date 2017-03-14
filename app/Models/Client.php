<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = ['id', 'store_id', 'first_name', 'last_name', 'email', 'telephone_number', 'mobile_number', 'amount'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
	protected $hidden  = ['created_at', 'updated_at'];

}