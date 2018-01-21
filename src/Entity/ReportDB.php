<?php
/**
 * Created by PhpStorm.
 * User: joaod
 * Date: 21/01/2018
 * Time: 16:51
 */

namespace App\Entity;

use App\Util\Database;

class ReportDB extends Database
{
    public function getDepositsAndWithdrawalsByCountrySince( array $Date ) : array
    {
        $Sql = 'CALL sp_GetTotalDepositAndWithdrawalsByGivenDate( ? )';

        $Statement = $this->PDO->prepare( $Sql );

        $Statement->execute( $Date );

        $Result = $Statement->fetchAll( $this->PDO::FETCH_ASSOC );

        return(
        [
            'Contents' => $Result
        ]
        );
    }
}