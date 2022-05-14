<?php

namespace module;


class Redis extends \Redis
{
    public static function redis() {
        $con = new \Redis();
        $config = config('redis.');
        $con->connect($config['host'], $config['port'], 5);
        $con->auth($config['auth']);
        return $con;
    }
}