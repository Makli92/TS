<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @SWG\Definition(required={"id", "name", "street", "street_number", "phone_number", "post_code", "city", "country", "latitude", "longitude"})
 */
class Store extends Model{

    /**
     * @SWG\Property(property="id", type="integer", format="int64")
     */

    /**
     * @SWG\Property(property="name", type="string")
     */

    /**
     * @SWG\Property(property="street", type="string")
     */

    /**
     * @SWG\Property(property="street_number", type="string")
     */

    /**
     * @SWG\Property(property="phone_number", type="string")
     */

    /**
     * @SWG\Property(property="post_code", type="string")
     */

    /**
     * @SWG\Property(property="city", type="string")
     */

    /**
     * @SWG\Property(property="country", type="string")
     */

    /**
     * @SWG\Property(property="latitude", type="string")
     */

    /**
     * @SWG\Property(property="longitude", type="string")
     */
    protected $table = "stores";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = ['id', 'name', 'street', 'street_number', 'phone_number', 'post_code', 'city', 'country', 'latitude', 'longitude'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
	protected $hidden   = ['created_at', 'updated_at', 'pivot'];

    public function staff()
    {
        return $this->belongsToMany('App\Models\User', 'users_to_stores', 'store_id', 'user_id')->select(array('id', 'first_name', 'last_name'));
    }

}