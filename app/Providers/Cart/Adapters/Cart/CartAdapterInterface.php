<?php namespace App\Providers\Cart\Adapters\Cart;

/**
 * Description of CartAdapterInterface
 *
 * @author Sandeep Rajoria <sandeep.rajoria@yahoo.co.in>
 * @date   4 Mar, 2017
 */
interface CartAdapterInterface {
    
    /**
     * Setter function for the user of the class
     * @param Model $user
     */
    public function setUser($user);
    
    /**
     * Function to get the cart details for a user
     * 
     * @return array Key value pair of all the details of all the items in the user's cart
     */
    public function getAllItems();
    
    /**
     * Function to add a cart item to a user's cart
     * 
     * @param integer ID of the product to be added
     * @param integer Quantity of the product to be added
     * @param integer Total price
     * @return bool Whether successfully added or not
     */
    public function add($product_id, $quantity, $price);
    
    /**
     * Function to remove items from the cart of a user
     * 
     * @param integer ID of the product to be added
     * @param integer Quantity of the product to be added
     * @param integer Price to be reduced on deletion
     * @return bool Whether successfully deketed or not
     */
    public function delete($product_id, $quantity, $price);
    
    /**
     * Function to delete items from the user's cart
     * 
     * @return bool Whether successfully deleted or not
     */
    public function deleteAllItems();
    
}
