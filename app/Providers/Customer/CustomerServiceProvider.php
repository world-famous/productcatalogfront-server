<?php
namespace App\Providers\Customer;

use Illuminate\Support\ServiceProvider;
use App\Providers\Customer\Customer;

/**
 * Description of CustomerServiceProvider
 *
 * @author Sandeep Rajoria <sandeep.rajoria@yahoo.co.in>
 * @date   6 Mar, 2017
 */
class CustomerServiceProvider extends ServiceProvider{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool 
     */
    protected $defer = false;
    
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
    }
    
    /**
     * Register the service provider
     * 
     * @return void
     */
    public function register()
    {
        
        // register providers
        $this->registerCustomerAdapter();
        
        //finally call the customer class
        $this->registerCustomer();
    }
    
    /**
     * Bind the customer adapter to the app
     * 
     * @return void
     */
    protected function registerCustomerAdapter(){
        $this->app->bind('App\Providers\Customer\Adapters\CustomerAdapterInterface', 'App\Providers\Customer\Adapters\EloquentCustomerAdapter');
    }
    
    /**
     * And finally register the Cart class which would be returned when the Facade is accessed
     */
    protected function registerCustomer(){
        //Lets bind the class here, and we can use this as an alias also
        $this->app->bind('customer', function($app) {
            return new Customer(
                    $app['App\Providers\Customer\Adapters\CustomerAdapterInterface']
                    );
        });
        
    }
    
    /**
    * Get the services provided by the provider.
    *
    * @return array
    */
    public function provides(){
        return [];
    }
}
