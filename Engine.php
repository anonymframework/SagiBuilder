<?php

namespace Sagi\Database;

use Exception;
use PDO;
use Sagi\Database\Drivers\Driver;
use Sagi\Database\Drivers\MysqlDriver;

/**
 * Class Engine
 * @package Sagi\Database
 */
class Engine
{

    /**
     * @var array
     */
    private $drivers = [
        'mysql' => 'Sagi\Database\Drivers\MysqlDriver',
        'sqlite' => 'Sagi\Database\Drivers\SqliteDriver',
        'pqsql' => 'Sagi\Database\Drivers\PorteqsqlDriver',
    ];

    /**
     * @var Driver
     */
    private $driver;

    /**
     * Engine constructor.
     * @param array $configs
     * @param string $table
     * @throws Exception
     */
    public function __construct()
    {
        $configs = ConfigManager::getConfigs();

        if (isset($configs['driver'])) {
            $driver = $configs['driver'];
            if (isset($this->drivers[$driver])) {
                $driver = $this->drivers[$driver];

                $this->driver = new $driver;
            } else {
                throw new Exception(sprintf('%s driver not found', $driver));
            }

        } else {
            throw new Exception('We need to your host,dbname,username and password informations for make a successfull connection ');
        }


        Connector::madeConnection($configs);
        $this->pdo = Connector::getConnection();

    }



}