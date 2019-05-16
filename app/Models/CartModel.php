<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of CartModel
 *
 * @author Sandeep Rajoria <sandeep.r@rahndevoo.com>
 * @date   5 Mar, 2017
 */

class CartModel extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'carts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['price', 'quantity', 'product_id', 'user_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
    
    /**
     * Reverse One to many relationship to Professional
     *
     */
    public function user() {
        return $this->belongsTo('App\Models\User');
    }
    
    /**
     * Reverse One to many relationship to Profession
     *
     */
    public function product() {
        return $this->belongsTo('App\Models\ProductModel');
    }

}
