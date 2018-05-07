<?php
/**
 * Created by PhpStorm.
 * User: marvin
 * Date: 05/05/18
 * Time: 17:48
 */

/** @var \Silex\Application $api */
$api = new Silex\Application();


/**
 * Database configuration file
 */
require_once __DIR__ . '/../config/database.php';

/**
 * Load General Resources (Controllers, Retrievers, Serializers, others)
 */
require_once __DIR__ . '/../src/Bundle/Resources/project.php';
require_once __DIR__ . '/../src/Bundle/Resources/script.php';
require_once __DIR__ . '/../src/Bundle/Resources/voice.php';

/**
 * Load Routing Resources
 */
require_once __DIR__ . '/../src/Bundle/Routes/voice.php';

return $api;