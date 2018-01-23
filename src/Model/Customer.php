<?php
/**
 * Created by PhpStorm.
 * User: joaod
 * Date: 21/01/2018
 * Time: 13:32
 */

namespace App\Model;


use App\Entity\CustomerDB;
use App\Util\Validation;
use Symfony\Component\HttpFoundation\JsonResponse;

class Customer
{
    protected $IdCustomer;

    protected $EmailAddress;

    protected $FirstName;

    protected $LastName;

    protected $Country;

    protected $Gender;

    public function create( array $RequestArray ) : JsonResponse
    {
        try
        {

            $Validation = new Validation();

            $FirstName = $Validation->filterString( $RequestArray['FirstName'] ?: '' );

            $LastName = $Validation->filterString( $RequestArray['LastName'] ?: '' );

            $EmailAddress = $Validation->filterEmail( $RequestArray['EmailAddress'] ?: '' );

            $Country = $Validation->getCountryIfValid(
                $RequestArray['Country'] ?
                    strtoupper($RequestArray['Country'] ) :
                    ''
            );

            $Gender = $Validation->getGenderIfValid(
                $RequestArray['Gender'] ?
                    ucfirst( strtolower( $RequestArray['Gender'] ) ) :
                    ''
            );

            $this->EmailAddress = $EmailAddress;

            $this->FirstName = $FirstName;

            $this->LastName = $LastName;

            $this->Country = $Country;

            $this->Gender = $Gender;

        }
        catch ( \Exception $Exception )
        {

            return new JsonResponse( [
                'Success' => 'false',
                'ErrorMessage' => $Exception->getMessage( )
            ] , 422 );

        }

        try
        {

            $CustomerEntity = new CustomerDB();

            $this->IdCustomer = $CustomerEntity->create( $this->getCreateParameters() );

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
                'CustomerId' => $this->IdCustomer
            ]
        ] , 200 );

    }

    public function edit( array $RequestArray ) : JsonResponse
    {
        try
        {

            $Validation = new Validation();

            $IdCustomer = $Validation->filterInt(
                isset( $RequestArray['IdCustomer'] )
                    ? $RequestArray['IdCustomer']
                    : ''
            );

            $FirstName = $Validation->sanitizeString(
                isset( $RequestArray['FirstName'] )
                    ? $RequestArray['FirstName']
                    : ''
            );

            $LastName = $Validation->sanitizeString(
                isset( $RequestArray['LastName'] )
                    ? $RequestArray['LastName']
                    : ''
            );

            $EmailAddress = $RequestArray['EmailAddress'] ?: '';

            if ($EmailAddress !== '') {
                $EmailAddress = $Validation->filterEmail($EmailAddress);
            }

            $Country = $Validation->getCountryIfValidOrEmpty(
                isset( $RequestArray['Country'] )
                    ? strtoupper( $RequestArray['Country'] )
                    : ''
            );

            $Gender = $Validation->getGenderIfValidOrEmpty(
                isset( $RequestArray['Gender'] )
                    ? ucfirst( strtolower( $RequestArray['Gender'] ) )
                    : ''
            );

        }
        catch ( \Exception $Exception )
        {
            return new JsonResponse( [
                'Success' => 'false',
                'ErrorMessage' => $Exception->getMessage( ),
            ] , 422 );
        }

        try
        {
            $CustomerEntity = new CustomerDB();

            $ResultArray = $CustomerEntity->edit(
                [
                    'IdCustomer' => $IdCustomer,
                    'FirstName' => $FirstName,
                    'LastName' => $LastName,
                    'EmailAddress' => $EmailAddress,
                    'Country' => $Country,
                    'Gender' => $Gender
                ]
            );
        }
        catch( \Exception $Exception )
        {
            return new JsonResponse( [
                'Success' => 'false',
                'ErrorMessage' => $Exception->getMessage( )
            ] , 409 );
        }

        return new JsonResponse( [
            'Success' => 'true',
            'Contents' => [
                'CustomerId' => $ResultArray
            ]
        ] , 200 );

    }


    public function getCreateParameters( ) : array
    {
        return array(
            $this->FirstName,
            $this->LastName,
            $this->EmailAddress,
            $this->Country,
            $this->Gender
        );
    }

}
