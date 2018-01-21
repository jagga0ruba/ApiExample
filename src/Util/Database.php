<?php
/**
 * Created by PhpStorm.
 * User: joaod
 * Date: 14/01/2018
 * Time: 15:11
 */

namespace App\Util;
use PDO;
use Symfony\Component\Yaml\Yaml;

class Database
{

    protected $PDO;

    public function __construct( )
    {

        $Path = dirname(__FILE__, 3) . '\config\database.yaml';

        $DbYaml = Yaml::parseFile($Path)['BackendExample'];

        $Dsn =  'mysql:host=' . $DbYaml['host'] .
            ';dbname=' .  $DbYaml['database'] .
            ';charset=' . $DbYaml['charset'];

        $this->PDO = new PDO($Dsn, $DbYaml['username'], $DbYaml['password']);

        $this->PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->PDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    public function getConnection() : PDO
    {
        return( $this->PDO );
    }
}