<?php
/**
 * Created by PhpStorm.
 * User: S3916
 * Date: 2019/2/20
 * Time: 14:33
 */
namespace component;

class Mysql
{
    public $config;
    private $connect;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function getConnection($keepAlive = false)
    {
        if ($this->connect instanceof \PDO) {
            return $this->connect;
        }

        $dsn[] = 'mysql:dbname=' . $this->config['database'];
        $dsn[] = 'host=' . $this->config['host'];
        $dsnStr = implode(';', $dsn);
        $user = $this->config['username'];
        $password = $this->config['password'];

        try {
            $this->connect = new \PDO($dsnStr, $user, $password);
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }

        return $this->connect;
    }
}