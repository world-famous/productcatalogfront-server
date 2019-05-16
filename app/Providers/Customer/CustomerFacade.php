<?php namespace App\Providers\Customer;

use Illuminate\Support\Facades\Facade;

/**
 * Description of CustomerFacade
 *
 * @author Sandeep Rajoria <sandeep.rajoria@yahoo.co.in>
 * @date   6 Mar, 2017
 */
class CustomerFacade extends Facade {
     /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'customer';
    }

}
