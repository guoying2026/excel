<?php

//获取项目根目录的绝对路径
define('INC_ROOT', dirname(__DIR__));
// var_dump(INC_ROOT);
//获取项目public目录的绝对路径
define('SITE_PATH', getcwd());
// var_dump(SITE_PATH);
define('USER_NAME',getenv('USERNAME'));
// define('DOC_ROOT', "\\\\AAECNBJ005802N.AD001.SIEMENS.NET\\Sharing\\");
define('DOC_ROOT_1', INC_ROOT .'\public\upload');
// var_dump(DOC_ROOT_1);
// Require composer autoloader
require_once INC_ROOT . '/vendor/autoload.php';

//在html中引用js时的目录
define('ASSET_ROOT','http://'.$_SERVER['HTTP_HOST']);

define('CONTROL_URL',
    'http://'.$_SERVER['HTTP_HOST'].
    str_replace(
        $_SERVER['DOCUMENT_ROOT'],
        '',
        str_replace('\\', '/', INC_ROOT)
    )
);
