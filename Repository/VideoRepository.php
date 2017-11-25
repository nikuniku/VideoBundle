<?php

namespace ArcaSolutions\VideoBundle\Repository;

use ArcaSolutions\CoreBundle\Interfaces\EntityModulesRowInterface;
use ArcaSolutions\CoreBundle\Repository\EntityModulesRowRepository;

/**
 * VideoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class VideoRepository extends EntityModulesRowRepository implements EntityModulesRowInterface
{
    /**
     * Returns module name in lowercase
     *
     * @return string
     */
    function getModuleName()
    {
        return 'video';
    }
}