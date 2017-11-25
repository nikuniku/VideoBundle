<?php

namespace ArcaSolutions\VideoBundle\Repository;

use ArcaSolutions\CoreBundle\Repository\EntityCategoryRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Videocategory
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class VideocategoryRepository extends EntityCategoryRepository
{
    /**
     * VideocategoryRepository constructor.
     * Sets active items field
     *
     * @param EntityManager $em
     * @param ClassMetadata $class
     */
    public function __construct(EntityManager $em, ClassMetadata $class)
    {
        parent::__construct($em, $class);

        $this->activeItemsNameField = 'activeVideo';
    }

    /**
     * {@inheritdoc}
     */
    public function getParentCategories($limit = null, $featured = true)
    {
        $this->setMaxItems($limit);

        return parent::getParentCategories($featured);
    }
}