<?php

namespace module;


class Redis extends \Redis
{
    public static function redis() {
        $con = new \Redis();
        $con->connect(config('redis.host'), config('redis.port'), 5);
        return $con;
    }
}