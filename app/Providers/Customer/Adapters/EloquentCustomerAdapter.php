<?php namespace App\Providers\Customer\Adapters;

use App\Providers\Customer\Adapters\CustomerAdapterInterface;
use Illuminate\Support\Facades\Config;
use App\Providers\Customer\Exceptions\InvalidCustomerException;
use App\Providers\Customer\Exceptions\InvalidConfigurationException;

/**
 * Description of EloquentCustomerAdapter
 *
 * @author Sandeep Rajoria <sandeep.rajoria@yahoo.co.in>
 * @date  64 Mar, 2017
 */
class EloquentCustomerAdapter implements CustomerAdapterInterface{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $customer;

    /**
     * Create a new customer instance.
     *
     * @param  \Illuminate\Database\Eloquent\Model customer
     */
    public function __construct()
    {
        if(empty(Config::get('cart.models.customer'))){
            throw new InvalidConfigurationException();
        }
        $this->customer = \App::make(Config::get('cart.models.customer'));
    }
    
    /**
     * Function to get customer details
     * 
     * @param string $identifier or email
     * @param string possible values id/email
     * @return array key values pair of customer details
     */
    public function get($identifier, $type = 'id'){
        if($type == 'email'){
            $customer = $this->customer->with(['user' => function ($query) use ($identifier) {
                                            $query->where('email', $identifier);
                                        }]);
            if($customer->count() == 0){
                \Log::error("$identifier not a valid customer email in get@EloquentCustomerAdapter");
                throw new InvalidCustomerException("$identifier Not a valid customer", 400);
            }
            return $customer->first()->toArray();
        }elseif($type == 'id'){
            $customer = $this->customer->where('id', (int)$identifier);
            if($customer->count() == 0){
                \Log::error("ID $identifier not a valid customer ID in get@EloquentCustomerAdapter");
                throw new InvalidCustomerException("id $identifier Not a valid customer", 400);
            }
            return $customer->first()->toArray();
        }else{
            \Log::error("Empty argument in get@EloquentCustomerAdapter identifier - $identifier, type - $type");
            throw new \InvalidArgumentException("One of the arguments is empty", 400);
        }
    }
    
    /**
     * Function to add customer details
     * 
     * @param array $customer_details
     * @return Model  Model of the user added
     */
    public function add($customer_details){
        if(empty($customer_details)){
            \Log::error("Empty argument in add@EloquentCustomerAdapter cutomer_details - ".json_encode($customer_details));
            throw new \InvalidArgumentException("One of the arguments is empty", 400);
        }
            
        return $this->customer->create([
            'user_id' => $customer_details['user_id'],
            'gender' => $customer_details['gender'],
            'active' => $customer_details['active'],
        ]);
    }
    
    /**
     * Function to update customer details
     * 
     * @param integer $customer_id
     * @param array key value pair to be updated
     * @return bool Whether updated or not
     */
    public function update($customer_id, $customer_details){
        if(empty($customer_id) || empty($customer_details)){
            \Log::error("Empty argument in update@EloquentCustomerAdapter customer_id - $customer_id, customer_details - ".json_encode($customer_details));
            throw new \InvalidArgumentException("One of the arguments is empty", 400);
        }
        
        $customer_object = $this->customer->find($customer_id);
        if($customer_object->count() == 0){
            \Log::error("ID $customer_id not a valid customer ID in update@EloquentCustomerAdapter");
            throw new InvalidCustomerException("id $customer_id Not a valid customer id", 400);
        }
        return $customer_object->update($customer_details);
    }
    
    /**
     * Function to delete a customer
     * 
     * @param string $identifier or email
     * @param string possible values id/email
     * @return bool Whether deleted or not
     */
    public function delete($identifier, $type = 'id'){
        if($type == 'email'){
            $customer = $this->customer->with(['user' => function ($query) use ($identifier) {
                                            $query->where('email', $identifier);
                                        }]);
            if($customer->count() == 0){
                \Log::error("$identifier not a valid customer email in get@EloquentCustomerAdapter");
                throw new InvalidCustomerException("$identifier Not a valid customer", 400);
            }
            return $customer->delete();
        }elseif($type == 'id'){
            $customer = $this->customer->where('id', (int)$identifier);
            if($customer->count() == 0){
                \Log::error("ID $identifier not a valid customer ID in get@EloquentCustomerAdapter");
                throw new InvalidCustomerException("id $identifier Not a valid customer", 400);
            }
            return $customer->delete();
        }else{
            \Log::error("Empty argument in get@EloquentCustomerAdapter identifier - $identifier, type - $type");
            throw new \InvalidArgumentException("One of the arguments is empty", 400);
        }
    }
    
}
