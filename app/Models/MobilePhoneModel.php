<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobilePhoneModel extends Model{

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
    /*public function spareParts(){
        return $this->hasMany('App\Models\SparePart');
    }*/
}