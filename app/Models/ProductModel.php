<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

/**
 * Description of ProductModel
 *
 * @author Sandeep Rajoria <sandeep.r@rahndevoo.com>
 * @date   5 Mar, 2017
 */
class ProductModel extends Model
{

    //The attribute to check for soft delete
    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['product_name', 'product_category', 'product_sub_category', 'sku','attributes', 'price'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];


    /**
     * Function to get all the attributes of the Product in an array
     */
    public function get_attributes() {
        return json_decode($this->attributes);
    }

    /**
     * Function to update the created_by and updated_by attributes of the table
     */
    public static function boot() {

        // Update field update_by with current user id each time article is updated.
        static ::updating(function ($item) {
            if (Auth::user()) $item->updated_by = Auth::user()->id;
             // Logged in user's id

        });

        self::creating(function ($item) {
            if (Auth::user()) $item->created_by = Auth::user()->id;
             // Logged in user's id

        });
    }

        public static function fullTextSearch($productname,$startdate,$enddate,$price){

            $maxprice=$request['price']+1000;
            $start = date("Y-m-d",strtotime($startdate));
            $end = date("Y-m-d",strtotime($enddate));
            $products = self::where("product_name", "LIKE","%".$request['productname']."%")
                        ->whereBetween("created_at", [$start,$end])
                        ->whereBetween("price",[$request['price'],$maxprice])
                        ->get();
    }
}
