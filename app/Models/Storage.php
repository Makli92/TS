<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Storage extends Model{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = ['id', 'store_id', 'spare_part_id', 'amount'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
	protected $hidden   = ['created_at', 'updated_at'];

}