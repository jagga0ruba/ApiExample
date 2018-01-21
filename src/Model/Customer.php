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

    private $CustomerEntity;

    public function create( array $RequestArray ) : JsonResponse
    {
        try
        {
            $Validation = new Validation();

            $FirstName = $Validation->filterString( $RequestArray['FirstName'] ? : '' );

            $LastName = $Validation->filterString( $RequestArray['LastName'] ? : '' );

            $EmailAddress = $Validation->filterEmail( $RequestArray['EmailAddress'] ? : '' );

            $Country = $Validation->getCountryIfValid( $RequestArray['Country'] ? : '' );

            $Gender = $Validation->getGenderIfValid( $RequestArray['Gender'] ? : '' );

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
            $this->CustomerEntity = new CustomerDB();

            $this->IdCustomer = $this->CustomerEntity->create( $this->getCreateParameters() );
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
            'Content' => [
                'CustomerId' => $this->IdCustomer
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

    public function getEditParameters( ) : array
    {

    }
}