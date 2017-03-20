<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mobile_Phone_Model extends Model{

    protected $table = "mobile_phone_models";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = ['id', 'brand_id', 'name'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
	protected $hidden   = ['created_at', 'updated_at'];
    /**
     * Define a one-to-many relationship with App\Models\SparePart
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function spareParts(){
        return $this->hasMany('App\Models\Spare_Part', 'mobile_phone_model_id', 'id');
    }

    public function brand()
    {
        return $this->belongsTo('App\Models\Brand');
    }
}