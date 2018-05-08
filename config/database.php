<?php
/**
 * Created by PhpStorm.
 * User: marvin
 */

use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\SimplifiedYamlDriver;

$config = new Configuration();

$cache = new \Doctrine\Common\Cache\ApcCache();

$config->setProxyDir(__DIR__ . '/../data/Proxy');
$config->setProxyNamespace('EntityProxy');
$config->setAutoGenerateProxyClasses(\Doctrine\Common\Proxy\AbstractProxyFactory::AUTOGENERATE_FILE_NOT_EXISTS);

$driver = new SimplifiedYamlDriver([
    __DIR__ . '/../src/Bundle/Entity' => 'Entity'
]);

$config->setMetadataDriverImpl($driver);

$conn =  [
    'driver' => 'pdo_sqlite',
    'path' => __DIR__.'/../database/database.sqlite',
];

//getting the EntityManager
$entityManager = EntityManager::create($conn, $config);

$api[\Doctrine\ORM\EntityManager::class] = $entityManager;

$api['debug'] = 'true';