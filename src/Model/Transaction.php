<?php
/**
 * Created by PhpStorm.
 * User: joaod
 * Date: 21/01/2018
 * Time: 16:13
 */

namespace App\Model;


use App\Entity\TransactionDB;
use App\Util\Validation;
use Symfony\Component\HttpFoundation\JsonResponse;

class Transaction
{
    public function deposit( array $RequestArray ) : JsonResponse
    {

        try
        {
            $Validation = new Validation();

            $IdCustomer = $Validation->filterInt( $RequestArray[ 'IdCustomer' ] ? : '' );

            $Amount = $RequestArray['Amount'];

            if( strpos( $Amount , ',') === false )
            {

                $Amount = $Amount . ',00';

            }

            $Amount = $Validation->sanitizeFloat( $Amount );
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

            $TransactionEntity = new TransactionDB();

            $Result = $TransactionEntity->deposit(
                [
                    $IdCustomer,
                    $Amount
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

    public function withdraw( array $RequestArray ) : JsonResponse
    {

        try
        {
            $Validation = new Validation();

            $IdCustomer = $Validation->filterInt( $RequestArray[ 'IdCustomer' ] ? : '' );

            $Amount = $RequestArray['Amount'];

            if( strpos( $Amount , ',') === false )
            {

                $Amount = $Amount . ',00';

            }

            $Amount = $Validation->sanitizeFloat( $Amount );
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

            $TransactionEntity = new TransactionDB();

            $Result = $TransactionEntity->withdraw(
                [
                    $IdCustomer,
                    $Amount
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