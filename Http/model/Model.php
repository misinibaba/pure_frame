<?php
namespace Http\model;

use bootstrap\facades\App;


class Model
{
    private static $connection;

    public function __construct()
    {
        self::$connection = App::get('mysql')->getConnection();
    }

    public static function query($sql, $params)
    {
        new static;

        $stmt = self::$connection->prepare($sql);

        foreach ($params as $key => &$param) {
            switch (gettype($param)) {
                case 'integer':
                    $type = \PDO::PARAM_INT;
                    break;
                case 'string':
                    $type = \PDO::PARAM_STR;
                    break;
                case 'boolean':
                    $type = \PDO::PARAM_BOOL;
                    break;
                default:
                    throw new \Exception('错误的PDO类型' . gettype($param));
                    break;
            };
            $stmt->bindParam($key, $param, $type);
        }

        $stmt->execute();
//        echo $stmt->debugDumpParams();die;
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
