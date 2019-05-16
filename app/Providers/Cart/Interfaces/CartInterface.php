<?php namespace App\Providers\Cart\Interfaces;

/**
 * Description of CartInterface
 *
 * @author Sandeep Rajoria <sandeep.rajoria@yahoo.co.in>
 * @date   4 Mar, 2017
 */
interface CartInterface {
    
    /**
     * Get details of the passed cart id
     * 
     * @return array Key value pair of the details
     */
    public function get();
    
    /**
     * Add product to cart
     * 
     * @param integer Id of the product to be added
     * @param integer Number of the products to be added
     * @param decimal Price of a single product(maybe discounts are applied or something hence passable) elase takes the default value
     * @return bool Whether products were added successfully
     */
    public function addProduct($product_id, $quantity, $price = null);
    
    /**
     * Remove products from cart
     * 
     * @param integer Id of the product to be removed
     * @param integer Number of the products to be removed
     * @return bool Whether product were removed successfully
     */
    public function removeProduct($product_id, $quantity);
    
    /**
     * Function to empty the cart of the user
     * 
     * @return bool Whether operation was successful
     */
    public function emptyCart();
    
    /**
     * Function to return the cart total
     * 
     * @return integer Total of all the cart items
     */
    public function cartTotal();
}
