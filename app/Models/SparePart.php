<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SparePart extends Model{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = ['id', 'mobilephonemodel_id', 'intrastat_code', 'price', 'min_vol', 'description'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
	protected $hidden   = ['created_at', 'updated_at'];
    /**
     * Define a many-to-many relationship with App\Models\SparePart
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function workOrders()
    {
        // Does not work
        return $this->belongsToMany('App\Models\WorkOrder', 'work_orders_spare_parts', 'spare_part_id', 'work_order_id');
    }
}