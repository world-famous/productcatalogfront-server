<?php
namespace App\Providers\Cart;

use App\Providers\Cart\Interfaces\CartInterface;
use App\Providers\Cart\Adapters\Cart\CartAdapterInterface;
use App\Providers\Cart\Interfaces\ProductInterface;
use App\Providers\Cart\Exceptions\InvalidCartException;
use App\Providers\Cart\Exceptions\InvalidUserException;
use App\User;

/**
 * Description of Cart
 *
 * @author Sandeep Rajoria <sandeep.rajoria@yahoo.co.in>
 * @date   4 Mar, 2017
 */
class Cart implements CartInterface {
    
    /** 
     * Dependency injection of App\Providers\Cart\Adapters\Cart\CartAdapterInterface
     *
     * @var App\Providers\Cart\Adapters\Cart\CartAdapterInterface 
     */
    protected $cart_model;
    
    /** 
     * Dependency injection of App\Providers\Cart\Interfaces\ProductInterface
     *
     * @var App\Providers\Cart\Interfaces\ProductInterface
     */
    protected $product;
    
    /**
     *
     * @var Current user
     */
    private $user;
    
    /**
     * Constructor
     * 
     * @param CartAdapterInterface $cart_model
     * @param ProductInterface $product
     */
    public function __construct(CartAdapterInterface $cart_model, ProductInterface $product){
        $this->cart_model = $cart_model;
        $this->product = $product;
    }
    
    /**
     * Setter function for the current user id where all the actions will be performed on
     * @param integer Id of the user
     */
    public function setUserId($user_id){
        
        //check whether such a user exists        
        $this->user = $this->_getUserObject($user_id);
        //need to set the user of the cart model also
        $this->cart_model->setUser($this->user);
    }
    
    /**
     * Getter function for the cart
     * 
     * @return interger Id of the current object's cart
     */
    public function getUserId(){
        return $this->user->id;
    }

    /**
     * Get details of the cart of the user
     * 
     * @return array Key value pair of the details
     */
    public function get(){
        $this->_checkUserSet();
        return $this->cart_model->getAllItems();
    }
    
    /**
     * Add product to cart
     * 
     * @param integer Id of the product to be added
     * @param integer Number of the products to be added
     * @param decimal Price of a single product(maybe discounts are applied or something hence passable) elase takes the default value
     * @return bool Whether products were added successfully
     */
    public function addProduct($product_id, $quantity, $price = null){
        $this->_checkUserSet();
        if(empty($price)){
            $price = $this->product->get($product_id)['price'] * $quantity;
        }
        
        $success = $this->cart_model->add($product_id, $quantity, $price);
        if($success){
            return true;
        }
        return false;
    }
    
    /**
     * Remove products from cart
     * 
     * @param integer Id of the product to be removed
     * @param integer Number of the products to be removed
     * @return bool Whether product were removed successfully
     */
    public function removeProduct($product_id, $quantity){
        $this->_checkUserSet();
        
        $success = $this->cart_model->delete($product_id, $quantity, ($this->product->get($product_id)['price'] * $quantity));
        if($success){
            return true;
        }
        return false;
    }
    
    /**
     * Function to empty the cart of the user
     * 
     * @return bool Whether operation was successful
     */
    public function emptyCart(){
        $success = $this->cart_model->deleteAllItems();
        if($success){
            return true;
        }
        return false;
    }
    
    /**
     * Function to return the cart total
     * 
     * @return integer Total of all the cart items
     */
    public function cartTotal(){
        $this->_checkUserSet();
        
        $cart_data = $this->cart_model->getAllItems();
        $total = 0;
        foreach($cart_data as $values){
            $total += $values['price']; 
        }
        
        return $total;
    }
    
    /**
     * Function to validate and set the private user variable
     * 
     * @param integer $user_id
     * @return Model 
     * @throws \InvalidArgumentException
     */
    private function _getUserObject($user_id){
        $user = User::find($user_id);
        if($user){
            return $user;
        }else{
            \Log::error("Not a valid user id - $user_id in _getUserObject@Cart");
            throw new InvalidUserException("Not a valid user", 400);
        }
    }

    /**
     * Private function to set if the user is set or not
     */
    private function _checkUserSet(){
        if(empty($this->user)){
            \Log::error("User not set in _checkUserSet@Cart");
            throw new InvalidCartException("User not set", 400);
        }
        
        return true;
    }
}
