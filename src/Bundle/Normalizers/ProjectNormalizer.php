<?php
/**
 * Created by PhpStorm.
 * User: marvin
 * Date: 08/05/18
 * Time: 16:56
 */

namespace Normalizers;

use Common\EntityNormalizer;

/**
 * Class ProjectNormalizer
 * @package Normalizers
 */
class ProjectNormalizer extends EntityNormalizer
{
    /**
     *
     */
    public function referenceConfiguration()
    {
        $callbacks = [];
        $this->setCallbacks($callbacks);
    }

    /**
     * @param array $fields
     */
    public function ignoreAttributesConfiguration($fields = [])
    {
        parent::ignoreAttributesConfiguration(['seats']);
    }
}