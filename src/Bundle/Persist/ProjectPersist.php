<?php
/**
 * Created by PhpStorm.
 * User: marvin
 * Date: 06/05/18
 * Time: 22:37
 */

namespace Persist;

use Common\AbstractPersist;
use Doctrine\ORM\EntityManager;
use Entity\Project;
use Retrieve\ProjectRetrieve;

class ProjectPersist extends AbstractPersist
{
    /**
     * @var ProjectRetrieve
     */
    private $projectRetrieve;

    /**
     * ProjectPersist constructor.
     * @param EntityManager $entityManager
     * @param ProjectRetrieve $projectRetrieve
     */
    public function __construct(
        EntityManager $entityManager,
        ProjectRetrieve $projectRetrieve
    ) {
        parent::__construct($entityManager);
        $this->projectRetrieve= $projectRetrieve;
    }

    /**
     * @param Project $project
     * @return Project
     * @throws \Doctrine\ORM\ORMException
     */
    public function process(Project $project)
    {
        /** @var Project $projectFromDB */
        $projectFromDB = $this->projectRetrieve->retrieveById($project->getId());

        if (!is_null($projectFromDB)) {
            return $this->update($projectFromDB);
        }

        return $this->create($project);
    }

    /**
     * @param Project $project
     * @return Project
     * @throws \Doctrine\ORM\ORMException
     */
    public function processDelete(Project $project)
    {
        return $this->delete($project);
    }
}