<?php
/**
 * Created by PhpStorm.
 * User: joaod
 * Date: 21/01/2018
 * Time: 13:00
 */

namespace App\Controller;

use App\Model\Customer;
use App\Util\ValidateContentTypeJson;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class CustomerController
{
    use ValidateContentTypeJson;

    /**
     * @Route( "/Customer/Create" )
     *
     * @param Request $Request
     * @return JsonResponse
     */
    public function create( Request $Request ) : JsonResponse
    {
        try
        {
            $RequestArray = $this->validateRequest( $Request );
        }
        catch( \Exception $Exception )
        {
            return new JsonResponse( [
                'Success' => 'false',
                'ErrorMessage' => $Exception->getMessage( )
            ] , 400 );
        }

        $Customer = new Customer();

        return( $Customer->create( $RequestArray ) );
    }

    /**
     * @Route( "/Customer/Edit" )
     *
     * @param Request $Request
     * @return JsonResponse
     */
    public function edit( Request $Request ) : JsonResponse
    {
        try
        {
            $RequestArray = $this->validateRequest( $Request );
        }
        catch( \Exception $Exception )
        {
            return new JsonResponse( [
                'Success' => 'false',
                'ErrorMessage' => $Exception->getMessage( )
            ] , 400 );
        }

        $Customer = new Customer();

        return( $Customer->edit( $RequestArray ) );

    }

}
