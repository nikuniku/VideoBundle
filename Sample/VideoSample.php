<?php
namespace ArcaSolutions\VideoBundle\Sample;

use ArcaSolutions\VideoBundle\Entity\Video;
use ArcaSolutions\ImageBundle\Sample\GalleryImageSample;
use ArcaSolutions\WebBundle\Sample\ReviewSample;
use Doctrine\Bundle\DoctrineBundle\Registry;

class VideoSample extends Video
{
    /**
     * Quantity of reviews in this sample
     *
     * @var int
     */
    private $reviewCount = 4;

    /**
     * Quantity of category in this sample
     *
     * @var int
     */
    private $categoriesCount = 2;

    /*
     * @var misc
     */
    private $translator;

    /**
     * @var Registry
     */
    private $doctrine;

    /**
     * VideoSample constructor.
     *
     * @param int $level
     */
    public function __construct($level = 0, $translator, $doctrine)
    {
        $this->translator = $translator;
        $this->doctrine = $doctrine;

        $this->setTitle($this->translator->trans('Video Title'))
            ->setFriendlyUrl('video-sample')
            ->setContent(
                '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque luctus enim ac diam malesuada vestibulum vitae at tortor. Nullam nec porttitor arcu. Pellentesque laoreet lorem egestas felis lobortis eu tincidunt nulla tempor. Phasellus adipiscing fringilla tempus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Curabitur sed sapien ut eros porta volutpat et quis leo. Aenean tincidunt ipsum quis nisl blandit nec placerat eros consectetur. Morbi convallis, est quis venenatis fermentum, sapien nibh auctor arcu, auctor mattis justo nisi tincidunt neque. Quisque cursus luctus congue. Quisque vel nulla vitae arcu faucibus placerat. Curabitur iaculis molestie sagittis.</p>'
            )
            ->setStatus('A');
    }

    /**
     * Gets categories sample
     *
     * @return array
     */
    public function getCategories()
    {
        $array = [];
        for ($i = 0; $i < $this->categoriesCount; $i++) {
            $array[] = new VideocategorySample($this->translator, $i);
        }

        return $array;
    }
}
