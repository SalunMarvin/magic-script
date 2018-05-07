<?php
/**
 * Created by PhpStorm.
 * User: Marvin
 * Date: 5/24/16
 * Time: 18:01
 */

namespace Retrieve;

use Common\AbstractRetrieve;

/**
 * Class ProjectRetrieve
 * @package Retrieve
 */
class ProjectRetrieve extends AbstractRetrieve
{
    protected function getEntityRepository()
    {
        return $this->entityRepository;
    }
}