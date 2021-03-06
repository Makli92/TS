<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model{

    protected $table = 'brands';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = ['id', 'name'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
	protected $hidden   = ['created_at', 'updated_at'];
    /**
     * Define a one-to-many relationship with App\Models\MobilePhoneModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mobilePhoneModels() {
        return $this->hasMany('App\Models\MobilePhoneModel', 'brand_id');
    }
}