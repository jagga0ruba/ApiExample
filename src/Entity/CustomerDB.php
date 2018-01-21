<?php
/**
 * Created by PhpStorm.
 * User: joaod
 * Date: 21/01/2018
 * Time: 13:24
 */

namespace App\Entity;

use App\Util\Database;

class CustomerDB extends Database
{

    public function create( array $CustomerCreateParameters )
    {

        $Sql = 'Call sp_CustomerAdd( ?, ?, ?, ?, ?)';

        $Statement = $this->PDO->prepare( $Sql );

        $Statement->execute( $CustomerCreateParameters );

        $Result = $Statement->fetch( $this->PDO::FETCH_ASSOC);

        return( $Result ["CustomerId"] );
    }

    public function edit( array $ParametersToEdit )
    {

        $PresentParameters = $this->getCustomerFromDatabaseWithId( $ParametersToEdit['IdCustomer'] );

        $NewParameters =
        [
            $ParametersToEdit['IdCustomer'],
             ( $ParametersToEdit['FirstName'] !== '' ) ?
                $ParametersToEdit['FirstName'] :
                $PresentParameters['FirstName'],
            ( $ParametersToEdit['LastName'] !== '' )  ?
                $ParametersToEdit['LastName'] :
                $PresentParameters['LastName'],
            ( $ParametersToEdit['EmailAddress'] !== '' ) ?
                $ParametersToEdit['EmailAddress'] :
                $PresentParameters['EmailAddress'],
            ( $ParametersToEdit['Country'] !== '' )  ?
                $ParametersToEdit['Country'] :
                $PresentParameters['Country'],
            ( $ParametersToEdit['Gender'] !== ''  ) ?
                $ParametersToEdit['Gender'] :
                $PresentParameters['Gender']
        ];

        return $this->updateUser( $NewParameters );
    }


    private function getCustomerFromDatabaseWithId( $Id ) : array
    {

        $Sql = 'Call sp_CustomerGetById(?)';

        $Statement = $this->PDO->prepare( $Sql );

        $Statement->execute( [ $Id ] );

        $Result = $Statement->fetch( $this->PDO::FETCH_OBJ );

        if( !isset( $Result->IdCustomer ) )
        {
            //did not have time to actually treat the errors from the db, sorry
            throw new \Exception( 'The Customer Id provided does not exist in the database' );
        }

        return[
            'IdCustomer' => $Result->IdCustomer,
            'FirstName' => $Result->FirstName,
            'LastName' => $Result->LastName,
            'EmailAddress' => $Result->EmailAddress,
            'Country' => $Result->Country,
            'Gender' => $Result->Gender
        ];
    }

    private function updateUser( array $ParametersToEdit ) : array
    {
        $Sql = 'Call sp_CustomerEdit(?,?,?,?,?,?)';

        $Statement = $this->PDO->prepare( $Sql );

        $Statement->execute( $ParametersToEdit );

        $Result = $Statement->fetch( $this->PDO::FETCH_ASSOC );

        return(
        [
            $Result
        ]
        );
    }
}