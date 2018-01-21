<?php
/**
 * Created by PhpStorm.
 * User: joaod
 * Date: 21/01/2018
 * Time: 13:00
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class CustomerController
{

    /**
     * @Route( "/Customer/Create" )
     *
     * @param Request $Request
     * @return JsonResponse
     */
    public function create( Request $Request )
    {
        var_dump( $Request->headers->get( 'Content-Type' ) );

        var_dump( $Request->getContent() );

        return( new JsonResponse( ["sup" => "200"], 200 ) );
    }

}