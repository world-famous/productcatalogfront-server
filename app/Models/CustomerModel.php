<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerModel extends Model
{
    protected $table = 'customers';
    protected $fillable = ['user_id', 'gender', 'active'];
    protected $hidden = [];
    protected $dates = ['created_at', 'updated_at'];

    /**
     * Customer belongs to a user
     */
    public function user() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
