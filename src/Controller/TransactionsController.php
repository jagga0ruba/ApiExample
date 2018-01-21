<?php
/**
 * Created by PhpStorm.
 * User: joaod
 * Date: 21/01/2018
 * Time: 15:49
 */

namespace App\Controller;


use App\Util\ValidateContentTypeJson;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Model\Transaction;

class TransactionsController
{
    use ValidateContentTypeJson;

    /**
     * @Route( "/Transaction/Deposit" )
     * @param Request $Request
     * @return JsonResponse
     */
    public function deposit( Request $Request) : JsonResponse
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


        $Transaction = new Transaction( );

        return $Transaction->deposit( $RequestArray );
    }

    /**
     * @Route( "/Transaction/Withdraw" )
     * @param Request $Request
     * @return JsonResponse
     */
    public function withdraw( Request $Request) : JsonResponse
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


        $Transaction = new Transaction( );

        return $Transaction->withdraw( $RequestArray );
    }

}