<?php
namespace App\Providers\Customer;

/**
 * Description of CustomerInterface
 *
 * @author Sandeep Rajoria <sandeep.rajoria@yahoo.co.in>
 * @date   6 Mar, 2017
 */
interface CustomerInterface {
    /**
     * Function to get details of a customer
     * @param integer id of the customer
     * @return array Key value pair of the customer details
     */
    public function get($customer_id);
    
    /**
     * Function to add a customer
     * 
     * @param array Key value pair of the customer details
     * @return  Model Customer that was added
     */
    public function add($customer_details);
    
    /**
     * Function to update customer info
     * 
     * @param integer $customer_id
     * @param array Key value pair of the data to be updated
     * @return bool Whether successfully udpated or not
     */
    public function update($customer_id, $customer_details);
    
    /**
     * Function to activate a customer
     * 
     * @param integer $customer_id
     * @return bool Whether activated or not
     */
    public function activate($customer_id);

    /**
     * Function to de-activate a customer
     * 
     * @param integer $customer_id
     * @return bool Whether deactivated or not
     */
    public function deactivate($customer_id);
    
}
