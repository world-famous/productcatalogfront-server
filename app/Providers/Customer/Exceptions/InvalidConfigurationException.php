<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Providers\Customer\Exceptions;

/**
 * Description of InvalidConfigurationException
 *
 * @author Sandeep Rajoria <sandeep.rajoria@yahoo.co.in>
 * @date   6 Mar, 2017
 */
class InvalidConfigurationException extends \Exception
{
    /**
     * Invalid configuration
     */
    public function __construct()
    {
        parent::__construct('Please provide a valid configuration');
    }
}
