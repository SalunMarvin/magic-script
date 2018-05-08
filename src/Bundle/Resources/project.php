<?php
/**
 * Created by PhpStorm.
 * User: marvin
 * Date: 06/05/18
 * Time: 22:47
 */


$api[\Controllers\ProjectController::class] = function ($api) {
    return new \Controllers\ProjectController(
        $api[\Controllers\ScriptController::class],
        $api[\Persist\ProjectPersist::class],
        $api[\Retrieve\ProjectRetrieve::class],
        $api[\Normalizers\ProjectNormalizer::class]
    );
};

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

$api[\Normalizers\ProjectNormalizer::class] = function () {
    $planeNormalizer = new \Normalizers\ProjectNormalizer();
    $planeNormalizer->setSerializer(new \Symfony\Component\Serializer\Serializer([$planeNormalizer]));
    return $planeNormalizer;
};