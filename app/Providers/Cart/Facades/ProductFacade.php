<?php
namespace App\Providers\Cart\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Description of ProductFacade
 *
 * @author Sandeep Rajoria <sandeep.rajoria@yahoo.co.in>
 * @date   4 Mar, 2017
 */
class ProductFacade extends Facade {
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'product';
    }
}
