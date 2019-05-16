<?php namespace App\Providers\Cart\Adapters\Cart;

use App\Providers\Cart\Adapters\Cart\CartAdapterInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use App\Providers\Cart\Exceptions\InvalidCartException;
use App\Providers\Cart\Exceptions\InvalidPriceException;
use App\Providers\Cart\Exceptions\InvalidQuantityException;
use App\Providers\Cart\Exceptions\InvalidUserException;
use App\Providers\Cart\Exceptions\InvalidConfigurationException;

/**
 * Description of EloquentCartAdapter
 *
 * @author Sandeep Rajoria <sandeep.rajoria@yahoo.co.in>
 * @date   4 Mar, 2017
 */
class EloquentCartAdapter implements CartAdapterInterface{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $cart;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $user;

    /**
     * Create a new cart instance.
     *
     * @param  \Illuminate\Database\Eloquent\Model cart
     */
    public function __construct()
    {
        if(empty(Config::get('cart.models.cart'))){
            throw new InvalidConfigurationException();
        }
        $this->cart = \App::make(Config::get('cart.models.cart'));
    }
    
    /**
     * Setter function for the user of the class
     * @param Model $user
     */
    public function setUser($user){
        $this->user = $user;
    }
    
    /**
     * Function to get the cart details for a user
     * 
     * @return array Key value pair of all the details of all the items in the user's cart
     */
    public function getAllItems(){
        $this->_checkUserSet();
        return $this->user->cartItems()->with(['product'])->get()->toArray();
    }
    
    /**
     * Function to add a cart item to a user's cart
     * 
     * @param integer ID of the product to be added
     * @param integer Quantity of the product to be added
     * @param integer Total price
     * @return bool Whether successfully added or not
     * @throws \InvalidArgumentException
     * @throws InvalidQuantityException
     * @throws InvalidPriceException
     */
    public function add($product_id, $quantity, $price){
        if(empty($product_id) || empty($quantity)|| empty($price)){
            \Log::error("Empty argument in add@EloquentCartAdapter product_id - $product_id, quantity - $quantity, price - $price");
            throw new \InvalidArgumentException("One of the arguments is empty", 400);
        }
        
        if(!($quantity > 0)){
            \Log::error("Invalid argument in add@EloquentCartAdapter quantity - $quantity");
            throw new InvalidQuantityException("$quantity is not a valid value");
        }
        
        if(!($price > 0)){
            \Log::error("Invalid argument in add@EloquentCartAdapter price - $price");
            throw new InvalidPriceException("$price is not a valid value");
        }
        
        $existing_records = $this->cart->where(['user_id' => $this->user->id,'product_id' => $product_id]);
        if($existing_records->count() == 0){
            return $this->cart->create([
                'user_id' => $this->user->id,
                'product_id' => $product_id,
                'quantity' => $quantity,
                'price' => $price
            ]);
        }else{
            $old_quantity = $existing_records->first()->quantity;
            $old_price = $existing_records->first()->price;
            return $this->cart->where(['user_id' => $this->user->id,'product_id' => $product_id])->first()->update(['quantity' => $old_quantity + $quantity, 'price' => $old_price + $price]);
        }
        
    }
    
    
    
    /**
     * Function to remove items from the cart of a user
     * 
     * @param integer ID of the product to be added
     * @param integer Quantity of the product to be added
     * @param integer Price to be reduced on deletion
     * @return bool Whether successfully deleted or not
     * @throws InvalidArgumentException
     * @throws InvalidQuantityException
     * @throws InvalidCartException
     * @throws InvalidPriceException
     */
    public function delete($product_id, $quantity, $price){
        if(empty($product_id) || empty($quantity)){
            \Log::error("Empty argument in delete@EloquentCartAdapter product_id - $product_id, quantity - $quantity");
            throw new \InvalidArgumentException("One of the arguments is empty", 400);
        }
        if(!($quantity > 0)){
            \Log::error("Invalid argument in delete@EloquentCartAdapter quantity - $quantity");
            throw new InvalidQuantityException("$quantity is not a valid value");
        }

        //see if the cart actually had this product
        $existing_records = $this->cart->where(['user_id' => $this->user->id,'product_id' => $product_id]);
        if($existing_records->count() == 0){
            \Log::error("Tried removing non existent product in delete@EloquentCartAdapter product_id - $product_id, quantity - $quantity, user - $user->id");
            throw new InvalidCartException("Not a valid cart product", 400);
        }
        
        //only if the product was already added we remove it
        $old_quantity = $existing_records->first()->quantity;
        $old_price = $existing_records->first()->price;
        if($old_quantity - $quantity == 0 ){//need to delete the row
            return $this->cart->where(['user_id' => $this->user->id,'product_id' => $product_id,])->delete();
        }
        else{//else update the exsiting record
            if(!($price > 0)){
                \Log::error("Invalid argument in delete@EloquentCartAdapter price - $price");
                throw new InvalidPriceException("$price is not a valid value");
            }
            return $this->cart->where(['user_id' => $this->user->id,'product_id' => $product_id,])->first()->update(['quantity' => $old_quantity - $quantity, 'price' => $old_price - $price]);
        }
        
    }
    
    /**
     * Function to delete items from the user's cart
     * 
     * @return bool Whether successfully deleted or not
     */
    public function deleteAllItems(){
        return $this->cart->where(['user_id' => $this->user->id])->delete();
    }
    
    /**
     * Private function to set if the user is set or not
     */
    private function _checkUserSet(){
        if(empty($this->user)){
            \Log::error("User not set in _checkUserSet@EloquentCartAdapter");
            throw new InvalidUserException("User not set", 400);
        }
        
        return true;
    }
}
