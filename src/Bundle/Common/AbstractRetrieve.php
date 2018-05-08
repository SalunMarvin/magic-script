<?php

/**
 * Created by PhpStorm.
 * User: Marvin
 * Date: 5/24/16
 * Time: 18:02
 */

namespace Common;

use Doctrine\ORM\EntityRepository;

abstract class AbstractRetrieve
{
    /**
     * @var EntityRepository
     */
    protected $entityRepository;

    /**
     * @param EntityRepository $entityRepository
     */
    public function __construct(EntityRepository $entityRepository)
    {
        $this->entityRepository = $entityRepository;
    }

    abstract protected function getEntityRepository();

    /**
     * @return array
     */
    public function retrieveAll()
    {
        return $this->entityRepository->findBy(['deletedAt' => null]);
    }

    /**
     * @param $id
     * @return null|object
     */
    public function retrieveById($id)
    {
        return $this->entityRepository->findOneBy(['id' => $id]);
    }

    /**
     * @param $referenceCode
     * @return null|object
     */
    public function retrieveByReferenceCode($referenceCode)
    {
        return $this->entityRepository->findOneBy(['referenceCode' => $referenceCode]);
    }

    /**
     * @return null|object
     */
    public function retrieveLast()
    {
        return $this->entityRepository->findOneBy(array(), array('id' => 'DESC'));
    }
}