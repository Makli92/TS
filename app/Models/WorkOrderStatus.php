<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkOrderStatus extends Model{

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
    protected $hidden  = ['created_at', 'updated_at'];

}