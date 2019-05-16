<?php
namespace App\Providers\Cart;

use Illuminate\Support\ServiceProvider;
use App\Providers\Cart\Cart;
use App\Providers\Cart\Product;

/**
 * Description of CartServiceProvider
 *
 * @author Sandeep Rajoria <sandeep.rajoria@yahoo.co.in>
 * @date   4 Mar, 2017
 */
class CartServiceProvider extends ServiceProvider{
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
        $this->registerProductAdapter();
        
        // register providers
        $this->registerCartAdapter();
        
        //Product class
        $this->registerProduct();
        
        //finally call the cart class
        $this->registerCart();
    }
    
    /**
     * Bind the cart adapter to the app
     * 
     * @return void
     */
    protected function registerCartAdapter(){
        $this->app->bind('App\Providers\Cart\Adapters\Cart\CartAdapterInterface', 'App\Providers\Cart\Adapters\Cart\EloquentCartAdapter');
    }
    
    /**
     * Bind the product adapter to the app
     * 
     * @return void
     */
    protected function registerProductAdapter(){
        $this->app->bind('App\Providers\Cart\Adapters\Product\ProductAdapterInterface', 'App\Providers\Cart\Adapters\Product\EloquentProductAdapter');
    }
    
    /**
     * Register the Product Class for use
     */
    protected function registerProduct(){
        //Lets bind the class here, and we can use this as an alias also
        $this->app->bind('product', function($app) {
            return new Product($app['App\Providers\Cart\Adapters\Product\ProductAdapterInterface']);
        });
        
    }
    
    /**
     * And finally register the Cart class which would be returned when the Facade is accessed
     */
    protected function registerCart(){
        //Lets bind the class here, and we can use this as an alias also
        $this->app->bind('cart', function($app) {
            \Log::info('in here');
            return new Cart(
                    $app['App\Providers\Cart\Adapters\Cart\CartAdapterInterface'],
                    $app['App\Providers\Cart\Product']
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
