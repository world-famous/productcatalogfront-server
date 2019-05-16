<?php namespace App\Providers\Customer\Adapters;

/**
 * Description of CustomerAdapterInterface
 *
 * @author Sandeep Rajoria <sandeep.rajoria@yahoo.co.in>
 * @date   6 Mar, 2017
 */
interface CustomerAdapterInterface {
    
    /**
     * Function to get customer details
     * 
     * @param string $identifier or name
     * @param string possible values id/email
     * @return array key values pair of customer details
     */
    public function get($identifier, $type = 'id');
    
    /**
     * Function to add customer details
     * 
     * @param array $customer_details
     * @return model Model of the user added
     */
    public function add($customer_details);
    
    /**
     * Function to update customer details
     * 
     * @param integer $customer_id
     * @param array key value pair to be updated
     * @return bool Whether updated or not
     */
    public function update($customer_id, $customer_details);
    
    /**
     * Function to delete a customer
     * 
     * @param string $identifier or email
     * @param string possible values id/email
     * @return bool Whether deleted or not
     */
    public function delete($identifier, $type = 'id');
}
