<?php namespace App\Providers\Cart\Adapters\Product;

use App\Providers\Cart\Adapters\Product\ProductAdapterInterface;
use Illuminate\Support\Facades\Config;
use App\Providers\Cart\Exceptions\InvalidProductException;
use App\Providers\Cart\Exceptions\InvalidPriceException;
use App\Providers\Cart\Exceptions\InvalidConfigurationException;

/**
 * Description of EloquentProductAdapter
 *
 * @author Sandeep Rajoria <sandeep.rajoria@yahoo.co.in>
 * @date   4 Mar, 2017
 */
class EloquentProductAdapter implements ProductAdapterInterface{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $product;

    /**
     * Create a new product instance.
     *
     * @param  \Illuminate\Database\Eloquent\Model product
     */
    public function __construct()
    {
        if(empty(Config::get('cart.models.product'))){
            throw new InvalidConfigurationException();
        }
        $this->product = \App::make(Config::get('cart.models.product'));
    }
    
    /**
     * Function to get all the products(top 10)
     * 
     * @param integer Number of records
     * @return array array of all the product with details
     */
    public function all($limit = 10){
        return $this->product->orderBy('id','desc')->limit($limit)->get()->toArray();
    }
            
    /**
     * Function to get the details of a product
     * 
     * @param string value - either name or id of the product
     * @param string possible values id/name
     * @return Array of all the details of the product
     */
    public function get($identifier, $type = 'id'){
        
        if($type == 'name'){
            $product = $this->product->where('product', $identifier);
            if($product->count() == 0){
                \Log::error("$identifier not a valid product in get@EloquentProductAdapter");
                throw new InvalidProductException("$identifier Not a valid product", 400);
            }
            return $product->first()->toArray();
        }elseif($type == 'id'){
            $product = $this->product->where('id', (int)$identifier);
            if($product->count() == 0){
                \Log::error("ID $identifier not a valid product ID in get@EloquentProductAdapter");
                throw new InvalidProductException("id $identifier Not a valid product", 400);
            }
            return $product->first()->toArray();
        }else{
            \Log::error("Empty argument in get@EloquentProductAdapter identifier - $identifier, type - $type");
            throw new \InvalidArgumentException("One of the arguments is empty", 400);
        }
    }
    
    /**
     * Function to add a new product item
     * 
     * @param string Name of the product to be added
     * @param string Category of the product
     * @param string SubCategory of the product
     * @param decimal Price of the product
     * @param array Key value pair
     * @return bool Successfully added or not
     */
    public function add($product_name, $product_category, $product_sub_category, $price, $attributes){
        if(empty($product_name) || empty($product_category) || empty($product_sub_category) || empty($attributes) ||empty($price)){
            \Log::error("Empty argument in add@EloquentProductAdapter product_name - $product_name, product_category - $product_category, product_sub_category - $product_sub_category, price - $price, attributes - ".json_encode($attributes));
            throw new \InvalidArgumentException("One of the arguments is empty", 400);
        }
        
        if(!($price > 0)){
            \Log::error("Invalid price passed in add@EloquentProductAdapter $price");
            throw new InvalidPriceException("Invalid price", 400);
        }
        
        return $this->product->create([
            'product_name' => $product_name,
            'product_category' => $product_category,
            'product_sub_category' => $product_sub_category,
            'price' => $price,
            'attributes' => json_encode($attributes),
        ]);
    }

    /**
     * Function to update an existing product
     * 
     * @param integer Id of the product to be updated
     * @param array key value pair of the data to be updated
     * @return bool Successfully updated or not
     */
    public function update($product_id, $product_data){
        if(empty($product_id) || empty($product_data)){
            \Log::error("Empty argument in update@EloquentProductAdapter product_id - $product_id, product_data - ".json_encode($product_data));
            throw new \InvalidArgumentException("One of the arguments is empty", 400);
        }
        
        $product_object = $this->product->find($product_id);
        if($product_object->count() == 0){
            \Log::error("ID $product_id not a valid product ID in update@EloquentProductAdapter");
            throw new InvalidProductException("id $product_id Not a valid product", 400);
        }
        return $product_object->update($product_data);
    }
    
    /**
     * Function to delete a product, would actually just disable it
     * 
     * @param string value - either name or id of the product
     * @param string possible values id/name
     * @return bool Successfully deleted or not
     */
    public function delete($identifier, $type = 'id'){
        
        if($type == 'name'){
            $product = $this->product->where('product',$identifier);
            if($product->count() == 0){
                \Log::error("$identifier not a valid product in get@EloquentProductAdapter");
                throw new InvalidProductException("$identifier Not a valid product", 400);
            }
            return $product->first()->delete();
        }elseif($type == 'id'){
            $product = $this->product->where('id', (int)($identifier));
            if($product->count() == 0){
                \Log::error("ID $identifier not a valid product ID in get@EloquentProductAdapter");
                throw new InvalidProductException("id $identifier Not a valid product", 400);
            }
            return $product->first()->delete();
        }else{
            \Log::error("Empty argument in delete@EloquentProductAdapter identifier - $identifier, type - $type");
            throw new \InvalidArgumentException("One of the arguments is empty", 400);
        }
    }
    
    /**
     * Function to do a full text search on the products Database and return the best matching products
     * 
     * @param string Text entered by the user to search a product
     * @param int Max number of products required to be returned
     * @return mixed Array of the top matching products
     */
    public function textSearch($keywords, $top = 5){
        /**
         * SELECT * 
           FROM products, plainto_tsquery($keywords) AS q 
           WHERE (searchtext @@ q) 
           ORDER BY ts_rank_cd(searchtext, plainto_tsquery($keywords)) DESC;
         */
        
        if(empty($keywords)){
            \Log::error("Empty argument in textSearch@EloquentProductAdapter keywords - $keywords");
            throw new \InvalidArgumentException("One of the arguments is empty", 400);
        }

        //cant return stuff on any other DB type
        if(config('database.default') !== 'pgsql'){
            return [];
        }
        
        $ts_table = \DB::raw("plainto_tsquery('$keywords') AS ts_table"); 
        
        $products = \DB::table('products')
            ->select("*")
            ->crossJoin($ts_table)
            ->whereRaw('(searchtext @@ ts_table)')
            ->orderBy(\DB::raw("ts_rank_cd(searchtext, plainto_tsquery('$keywords'))", 'DESC'))
            ->get()
            ->toArray();
        
        return $products;
    }
}
