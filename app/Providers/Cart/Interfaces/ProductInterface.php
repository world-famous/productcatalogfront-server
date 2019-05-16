<?php
namespace App\Providers\Cart\Interfaces;

/**
 * Description of ProductInterface
 *
 * @author Sandeep Rajoria <sandeep.rajoria@yahoo.co.in>
 * @date   4 Mar, 2017
 */
interface ProductInterface {
    /**
     * Function to get all products
     * 
     * @return array details of all the product if the id is valid
     */
    public function getAll();
    
    /**
     * Function to add a new Product
     * 
     * @param integer ID of the product to be updated
     * @return array details of the product if the id is valid
     */
    public function get($product_id);
    
    /**
     * Function to add a new Product
     * 
     * @param array Key value pair of the data which needs to be added
     * @return bool Whether successfully added or not
     */
    public function add($product_details);
        
    /**
     * Function to update and existing product
     * 
     * @param integer ID of the product to be updated
     * @param array Key value pair of the data which needs to be updated
     * @return bool Whether successfully added or not
     */
    public function update($product_id, $product_details);
    
    /**
     * Function to delete a product
     * 
     * @param integer  ID of the product to be deleted
     * @return bool Whether successfully deleted or not
     */
    public function delete($product_id);
    
    /**
     * Function to do a fulltext search on the products DB and return the best matching
     * 
     * @param string $keyword_text
     * @return array Array of the products found matching
     */
    public function fullTextSearch($keyword_text);

}
