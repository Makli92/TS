<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Work_Order_Status extends Model{

    protected $table = "work_order_statuses";
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