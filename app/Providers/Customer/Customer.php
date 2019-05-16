<?php
namespace App\Providers\Customer;

use App\Providers\Customer\CustomerInterface;
use App\Providers\Customer\Adapters\CustomerAdapterInterface;
use App\User;

/**
 * Description of Customer
 *
 * @author Sandeep Rajoria <sandeep.rajoria@yahoo.co.in>
 * @date   6 Mar, 2017
 */
class Customer implements CustomerInterface {
    
    /** 
     * Dependency injection of App\Providers\Customer\Adapters\CustomerAdapterInterface
     *
     * @var App\Providers\Customer\Adapters\CustomerAdapterInterface 
     */
    protected $customer_model;

    
    /**
     * Constructor
     * 
     * @param CustomerAdapterInterface $customer_model
     */
    public function __construct(CustomerAdapterInterface $customer_model){
        $this->customer_model = $customer_model;
    }
    
    /**
     * Function to get details of a customer
     * @param integer id of the customer
     * @return array Key value pair of the customer details
     */
    public function get($customer_id){
        return $this->customer_model->get($customer_id, 'id');
    }
    
    /**
     * Function to add a customer
     * 
     * @param array Key value pair of the customer details
     * @return Model Customer that was added
     */
    public function add($customer_details){
        //verify data here
        if(empty($customer_details['email']) || empty($customer_details['name'])){
            \Log::error("Empty argument in add@Customer customer_details - ".json_encode($customer_details));
            throw new \InvalidArgumentException("One of the arguments is empty", 400);
        }
        \DB::beginTransaction();

        try {
            //add
            $user = User::create([
                'name' => $customer_details['name'],
                'email' => $customer_details['email'],
                'password' => bcrypt($customer_details['password']),
            ]);
            $cust = $this->customer_model->add([
                'user_id' => $user->id,
                'active' => true,
                'gender' => $customer_details['gender'],
            ]);
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            throw new \Exception($e->getMessage());
        }
                
        return $cust;
    }
    
    /**
     * Function to update customer info
     * 
     * @param integer $customer_id
     * @param array Key value pair of the data to be updated
     * @return bool Whether successfully udpated or not
     */
    public function update($customer_id, $customer_details){
        //verify data here
        
        //update 
        return $this->customer_model->update($customer_id, $customer_details);
    }
    
    /**
     * Function to activate a customer
     * 
     * @param integer $customer_id
     * @return bool Whether activated or not
     */
    public function activate($customer_id){
        return $this->customer_model->update($customer_id, ['active' => true]);
    }

    /**
     * Function to de-activate a customer
     * 
     * @param integer $customer_id
     * @return bool Whether deactivated or not
     */
    public function deactivate($customer_id){
        return $this->customer_model->update($customer_id, ['active' => false]);
    }
    
}
