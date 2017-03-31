<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @SWG\Definition(required={"id", "name"})
 */
class MobilePhoneModel extends Model{

    /**
     * @SWG\Property(property="id", type="integer", format="int64")
     */

    /**
     * @SWG\Property(property="name", type="string")
     */
    protected $table = "mobile_phone_models";
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
	protected $hidden   = ['created_at', 'updated_at', 'brand_id'];
    /**
     * Define a one-to-many relationship with App\Models\SparePart
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function spareParts(){
        return $this->hasMany('App\Models\SparePart', 'mobile_phone_model_id', 'id');
    }

    public function brand()
    {
        return $this->belongsTo('App\Models\Brand');
    }
}