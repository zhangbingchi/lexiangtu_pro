<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
define('APP_HOST', $http_type . $_SERVER['HTTP_HOST']);
define('APP_URL', substr($_SERVER['SCRIPT_NAME'], 0, strripos($_SERVER['SCRIPT_NAME'], '/')));
define('APP_DIR', __DIR__);
define('APP_IMG_CDN', '');
define('APP_THEME', 'phpfly');
define('APP_RESPONSIVE', true);

define('APP_PATH', __DIR__ . '/../application/');

require __DIR__ . '/../thinkphp/base.php';