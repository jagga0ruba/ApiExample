<?php
/**
 * Created by PhpStorm.
 * User: joaod
 * Date: 21/01/2018
 * Time: 16:40
 */

namespace App\Controller;

use App\Util\ValidateContentTypeJson;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Model\Report;

class ReportController
{
    use ValidateContentTypeJson;

    /**
     * @Route( "/DepositsAndWithdrawalsByCountrySinceDate" )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getDepositsAndWithdrawalsByCountrySince( Request $Request ) : JsonResponse
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


        $Report = new Report( );

        return $Report->getDepositsAndWithdrawalsByCountrySince( $RequestArray );
    }
}