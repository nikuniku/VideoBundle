<?php
namespace ArcaSolutions\VideoBundle\Sample;

use ArcaSolutions\VideoBundle\Entity\Videocategory;

class VideocategorySample extends Videocategory
{
    /**
     * VideocategorySample constructor.
     *
     * @param misc $translator
     * @param int $counter
     */
    public function __construct($translator, $counter)
    {
        $this->setTitle($translator->trans('Category ').++$counter)
            ->setActiveVideo(rand() % 100 + 1)
            ->setFriendlyUrl('category-sample')
            ->setEnabled('y');
    }
}
