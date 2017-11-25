<?php

namespace ArcaSolutions\VideoBundle;

use ArcaSolutions\VideoBundle\Entity\Video;
use ArcaSolutions\VideoBundle\Entity\Internal\VideoLevelFeatures;
use ArcaSolutions\CoreBundle\Interfaces\ItemDetailInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class DealItemDetail
 *
 * @package ArcaSolutions\EventBundle
 */
final class VideoItemDetail implements ItemDetailInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var Video
     */
    private $item = null;

    /**
     * Doesn't have it
     */
    private $level = null;

    /**
     * @param ContainerInterface $containerInterface
     * @param Video    $video
     *
     */
    public function __construct(ContainerInterface $containerInterface, Video $video)
    {
        $this->container = $containerInterface;
        $this->item = $video;

        /* sets item's level */
        $this->setLevel();
    }

    /**
     * Sets item's level
     */
    private function setLevel()
    {
        /* gets levels */
        $this->level = VideoLevelFeatures::normalizeLevel(
            $this->getItem()->getLevelObj(),
            $this->container->get("doctrine")
        );
    }

    /** {@inheritdoc} */
    public function getModuleName()
    {
        return 'video';
    }

  
    /** {@inheritdoc} */
    public function getItem()
    {
        /* checks if item was seated */
        if (is_null($this->item)) {
            throw new \Exception('You must set the item');
        }

        return $this->item;
    }

    /**
     * Returns container object to give access on services
     *
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }
}
