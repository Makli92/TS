<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model{

    protected $table = 'devices';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = ['id', 'mobile_phone_model_id', 'imei'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
	protected $hidden   = ['created_at', 'updated_at'];
    /**
     * Define a one-to-many relationship with App\Models\Mobile_Phone_Model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mobilePhoneModel() {
        return $this->belongsTo('App\Models\Mobile_Phone_Model');
    }
}