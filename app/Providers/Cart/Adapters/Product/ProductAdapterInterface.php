<?php namespace App\Providers\Cart\Adapters\Product;

/**
 * Description of ProductAdapterInterface
 *
 * @author Sandeep Rajoria <sandeep.rajoria@yahoo.co.in>
 * @date   4 Mar, 2017
 */
interface ProductAdapterInterface {
    
    /**
     * Function to get all the products(top 10)
     * 
     * @param integer Number of records
     * @return array array of all the product with details
     */
    public function all($limit = 10);

    /**
     * Function to get the details of a product
     * 
     * @param string value - either name or id of the product
     * @param string possible values id/name
     * @return Array of all the details of the product
     */
    public function get($identifier, $type = 'id');
    
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
    public function add($product_name, $product_category, $product_sub_category, $price, $attributes);

    /**
     * Function to update an existing product
     * 
     * @param integer Id of the product to be updated
     * @param array key value pair of the data to be updated
     * @return bool Successfully updated or not
     */
    public function update($product_id, $product_data);
    
    /**
     * Function to delete a product, would actually just disable it
     * 
     * @param string value - either name or id of the product
     * @param string possible values id/name
     * @return bool Successfully deleted or not
     */
    public function delete($identifier, $type = 'id');
    
    /**
     * Function to do a full text search on the products Database and return the best matching products
     * 
     * @param string Text entered by the user to search a product
     * @param int Max number of products required to be returned
     * @return mixed Array of the top matching products
     */
    public function textSearch($keyword, $top = 5);
}
