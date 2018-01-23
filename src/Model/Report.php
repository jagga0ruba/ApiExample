<?php
/**
 * Created by PhpStorm.
 * User: joaod
 * Date: 21/01/2018
 * Time: 16:51
 */

namespace App\Model;


use App\Entity\ReportDB;
use App\Util\Validation;
use Symfony\Component\HttpFoundation\JsonResponse;

class Report
{
    public function getDepositsAndWithdrawalsByCountrySince( array $RequestArray ) : JsonResponse
    {
        try
        {

            $Validation = new Validation();

            $Date = $Validation->getDateInStringFormatIfValidOrEmpty(
                isset( $RequestArray[ 'Date' ] )
                    ? $RequestArray[ 'Date' ]
                    : ''
            );

        }
        catch( \Exception $Exception )
        {

            return new JsonResponse( [
                'Success' => 'false',
                'ErrorMessage' => $Exception->getMessage( )
            ] , 422 );

        }

        try
        {

            $ReportEntity = new ReportDB();

            $Result = $ReportEntity->getDepositsAndWithdrawalsByCountrySince(
                [
                    $Date
                ]
            );

        }
        catch ( \Exception $Exception )
        {

            return new JsonResponse( [
                'Success' => 'false',
                'ErrorMessage' => $Exception->getMessage( )
            ] , 409 );

        }

        return new JsonResponse( [
            'Success' => 'true',
            'Contents' => [
                $Result
            ]
        ] , 200 );
    }
}
