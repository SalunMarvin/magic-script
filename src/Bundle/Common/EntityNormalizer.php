<?php
/**
 * Created by PhpStorm.
 * User: marvin
 * Date: 08/05/18
 * Time: 16:51
 */

namespace Common;

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

abstract class EntityNormalizer extends ObjectNormalizer
{
    protected $fieldsToIgnore = [];

    public function __construct()
    {
        parent::__construct();
        $this->referenceConfiguration();
        $this->ignoreAttributesConfiguration();
        $this->setCircularReferenceLimit(0);
        $this->setCircularReferenceHandler(function () {
            return [];
        });
    }

    abstract public function referenceConfiguration();

    public function ignoreAttributesConfiguration($fields = [])
    {
        $predefinedFields = [
            'id',
            'timezone',
            'createdAt',
            'deletedAt',
            'updatedAt',
            'lastErrors',
            '__cloner__',
            '__initializer__',
            '__isInitialized__',
            'lazyPropertiesDefaults'
        ];
        $this->setIgnoredAttributes(array_merge($predefinedFields, $fields, $this->fieldsToIgnore));
    }

    /**
     * @param $collection
     * @return array
     */
    public function normalizeCollection($collection)
    {
        $normalizedEntities = [];

        foreach ($collection as $entity) {
            $normalizedEntity = $this->normalize($entity);
            $normalizedEntities[] = $normalizedEntity;
        }

        return $normalizedEntities;
    }

    /**
     * @param $collection
     * @param $class
     * @return array
     */
    public function denormalizeCollection($collection, $class)
    {
        $denormalizedEntities = [];

        foreach ($collection as $entity) {
            $denormalizedEntity = $this->denormalize($entity, $class);
            $denormalizedEntities[] = $denormalizedEntity;
        }

        return $denormalizedEntities;
    }
}