<?php
/**
 * Created by PhpStorm.
 * User: marvin
 * Date: 05/05/18
 * Time: 16:51
 */


/**
 * Set Headers and Locale settings
 */
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-type, Access-Control-Allow-Origin, Access-Control-Allow-Headers, Access-Control-Allow-Methods');

setlocale(LC_ALL, "pt_BR.utf-8", "pt_BR", "portuguese", "pt_BR.iso-8859-1");
date_default_timezone_set('America/Sao_Paulo');


/**
 * Load Composer Autoloader
 */
$loader = require_once __DIR__.'/../vendor/autoload.php';

/**
 * Start new Silex Application
 */
/** @var \Silex\Application $api */
$api = require_once __DIR__ . '/../src/app.php';


/**
 * Run Silex Application
 */
$api->run();