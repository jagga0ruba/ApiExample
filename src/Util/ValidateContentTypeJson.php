<?php

namespace App\Util;

use Symfony\Component\HttpFoundation\Request;

trait ValidateContentTypeJson{

    protected function validateRequest( Request $Request ) : array
    {
        $Validation = new Validation();

        $RequestArray = $Validation->checkForValidJsonRequest( $Request );

        return $RequestArray;
    }

}