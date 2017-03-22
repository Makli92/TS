<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VAT extends Model{

    protected $table = 'vat_categories';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = ['id', 'description', 'value'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
	protected $hidden   = ['created_at', 'updated_at'];
}