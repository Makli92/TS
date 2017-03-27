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
}