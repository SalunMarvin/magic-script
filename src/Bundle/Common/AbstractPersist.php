<?php
/**
 * Created by PhpStorm.
 * User: Marvin
 * Date: 5/26/16
 * Time: 11:47
 */

namespace Common;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Entity\Project;

/**
 * Class AbstractPersistService
 * @package Common\Service\Persist
 */
abstract class AbstractPersist
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Project $entity
     * @return Project
     * @throws ORMException
     */
    protected function create(Project $entity)
    {
        $entity->setCreatedAt(new \DateTime());

        return $this->save($entity);
    }

    /**
     * @param Project $entity
     * @return Project
     * @throws ORMException
     */
    protected function delete(Project $entity)
    {
        $entity->setDeletedAt(new \DateTime());

        return $this->save($entity);
    }

    /**
     * @param Project $entity
     * @return Project
     * @throws ORMException
     */
    protected function update(Project $entity)
    {
        $entity->setUpdatedAt(new \DateTime());

        return $this->save($entity);
    }

    /**
     * @param Project $entity
     * @return Project
     * @throws ORMException
     */
    private function save(Project $entity)
    {
        try {
            $this->entityManager->persist($entity);
            $this->entityManager->flush();
        } catch (ORMException $e) {
            throw $e;
        }

        return $entity;
    }

    protected function remove(Project $entity)
    {
        try {
            $this->entityManager->remove($entity);
            $this->entityManager->flush();
        } catch (ORMException $e) {
            throw $e;
        }

        return $entity;
    }
}