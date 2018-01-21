<?php
/**
 * Created by PhpStorm.
 * User: joaod
 * Date: 21/01/2018
 * Time: 12:19
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


class ApiController
{

    /**
    * @Route /
    * @param Request $Request
    * @return JsonResponse
    */
    public function hey( Request $Request )
    {

        var_dump( $Request->headers->get( 'Content-Type' ) );

        var_dump( $Request->getContent() );

        return( new JsonResponse( ["sup" => "200"], 200 ) );

    }
}