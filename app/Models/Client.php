<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model{

    protected $table = 'clients';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = ['id', 'first_name', 'last_name', 'mobile_number', 'phone_number', 'email', 'created_by_user_id', 'store_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
	protected $hidden   = ['created_at', 'updated_at'];
}