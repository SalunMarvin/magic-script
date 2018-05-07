<?php
/**
 * Created by PhpStorm.
 * User: marvin
 * Date: 06/05/18
 * Time: 22:47
 */

$api[\Retrieve\ProjectRetrieve::class] = function ($api) {
    /** @var \Doctrine\ORM\EntityManager $entityManager */
    $entityManager = $api[\Doctrine\ORM\EntityManager::class];

    return new \Retrieve\ProjectRetrieve(
        $entityManager->getRepository(\Entity\Project::class)
    );
};

$api[\Persist\ProjectPersist::class] = function ($api) {
    /** @var \Doctrine\ORM\EntityManager $entityManager */
    $entityManager = $api[\Doctrine\ORM\EntityManager::class];
    return new \Persist\ProjectPersist(
        $entityManager,
        $api[\Retrieve\ProjectRetrieve::class]
    );
};