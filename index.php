<?php

define('ROOT', 'http://' . $_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF']));

function loadClass($class)
{
    require_once __DIR__ . '/model/' . $class . '.php';
}

spl_autoload_register('loadClass');
require_once __DIR__ . '/commonFunction.php';

session_start();

if (isset($_GET['controller'])) {
    $controller = 'controller/' . $_GET['controller'] . '.php';
    require_once $controller;
}

require_once __DIR__ . '/view/template.php';

