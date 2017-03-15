<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'client_id', 'imei', 'description', 'notes', 'technician_id', 'workorderstatus_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden  = ['created_at', 'updated_at'];

    /**
     * Define a many-to-many relationship with App\Models\SparePart
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    // public function spareParts()
    // {
    //     return $this->belongsToMany('App\Models\SparePart', 'work_orders_spare_parts', 'work_order_id', 'spare_part_id');
    // }
}