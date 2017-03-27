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
	protected $hidden   = ['created_at', 'updated_at', 'pivot'];
    /**
     * Define a one-to-many relationship with App\Models\MobilePhoneModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mobilePhoneModel() {
        return $this->belongsTo('App\Models\MobilePhoneModel');
    }

    public function client() {
        return $this->belongsToMany('App\Models\Client', 'clients_to_devices', 'device_id', 'client_id')->withTimestamps()->select(array('id', 'first_name', 'last_name'));
    }
}