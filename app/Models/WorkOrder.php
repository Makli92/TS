<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model{

    protected $table = "work_orders";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'description', 'notes', 'assigned_to', 'client_id', 'status_id', 'device_id', 'store_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden  = ['created_at', 'updated_at'];

    public function spareParts()
    {
        return $this->belongsToMany('App\Models\SparePart', 'work_orders_to_spare_parts', 'work_order_id', 'spare_part_id')
                    ->withPivot('net_value', 'vat_value')
                    ->select(array('mobile_phone_model_id', 'intrastat_code', 'description', 'work_orders_to_spare_parts.net_value', 'work_orders_to_spare_parts.vat_value'));
    }
}