<?php
/**
 * Created by PhpStorm.
 * User: joaod
 * Date: 21/01/2018
 * Time: 13:24
 */

namespace App\Entity;


use App\Model\Customer;
use App\Util\Database;

class CustomerDB extends Database
{
    public function __construct()
    {

        parent::__construct();

    }

    public function create( array $CustomerCreateParameters )
    {

        $Sql = 'Call sp_CustomerAdd( ?, ?, ?, ?, ?)';

        $Statement = $this->PDO->prepare( $Sql );

        $Statement->execute( $CustomerCreateParameters );

        $Result = $Statement->fetch( $this->PDO::FETCH_ASSOC);

        return( $Result ["CustomerId"] );
    }
}