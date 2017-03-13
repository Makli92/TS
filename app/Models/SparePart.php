<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SparePart extends Model{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = ['id', 'mobile_phone_model_id', 'intrastat_code', 'price', 'min_vol', 'description'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
	protected $hidden   = ['created_at', 'updated_at'];
}