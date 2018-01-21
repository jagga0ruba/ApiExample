<?php
/**
 * Created by PhpStorm.
 * User: joaod
 * Date: 21/01/2018
 * Time: 16:12
 */

namespace App\Entity;


use App\Util\Database;
use Symfony\Component\HttpFoundation\Request;

class TransactionDB extends Database
{

    public function deposit( array $DepositArray ) : array
    {
        $Sql = 'Call sp_Deposit(?,?)';

        $Statement = $this->PDO->prepare( $Sql );

        $Statement->execute( $DepositArray );

        $Result = $Statement->fetch( $this->PDO::FETCH_ASSOC );

        return [
            'IdCustomer' => $Result['IdCustomer'],
            'TotalBalance' => substr_replace($Result['TotalBalance'], ',' , -2, 0),
            'BonusBalance' => substr_replace($Result['BonusBalance'], ',' , -2, 0)
        ];
    }

    public function withdraw( array $WithdrawArray ) : array
    {
        $Sql = 'Call sp_Withdraw(?,?)';

        $Statement = $this->PDO->prepare( $Sql );

        $Statement->execute( $WithdrawArray );

        $Result = $Statement->fetch( $this->PDO::FETCH_ASSOC );

        if( isset( $Result['IdCustomer'] ) ) {
            return [
                'Contents' =>
                    [
                        'IdCustomer' => $Result['IdCustomer'],
                        'TotalBalance' => substr_replace($Result['TotalBalance'], ',', -2, 0),
                        'BonusBalance' => substr_replace($Result['BonusBalance'], ',', -2, 0)
                    ]
            ];
        }

        throw new \Exception( $Result['Error'] );

    }
}