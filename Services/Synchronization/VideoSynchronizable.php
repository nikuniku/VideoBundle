<?php

namespace ArcaSolutions\VideoBundle\Services\Synchronization;

use ArcaSolutions\VideoBundle\Entity\Video;
use ArcaSolutions\VideoBundle\Entity\Videocategory;
use ArcaSolutions\VideoBundle\Search\VideoConfiguration;
use ArcaSolutions\CoreBundle\Services\Utility;
use ArcaSolutions\ElasticsearchBundle\Services\Synchronization\Modules\BaseSynchronizable;
use ArcaSolutions\ElasticsearchBundle\Services\Synchronization\Synchronization;
use ArcaSolutions\ImageBundle\Entity\Image;
use Elastica\Document;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class VideoSynchronizable extends BaseSynchronizable implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            'edirectory.synchronization' => 'handleEvent',
        ];
    }

    public function handleEvent($event, $eventName)
    {
        $this->generateAll();
    }

    function __construct(ContainerInterface $container)
    {
        parent::__construct($container);

        $this->configurationService = "video.search";
        $this->databaseType = Synchronization::DATABASE_DOMAIN;
        $this->upsertFormat = static::DOCUMENT_UPSERT;
        $this->deleteFormat = static::DELETE_ID_RAW;
    }

    public function generateAll($output = null, $pageSize = Synchronization::BULK_THRESHOLD)
    {
        $progressBar = null;
        $doctrine = $this->container->get("doctrine");
        $qB = $doctrine->getRepository("VideoBundle:Video")->createQueryBuilder('video');

        if ($output) {
            $totalCount = $qB->select('COUNT(video.id)')->getQuery()->getSingleScalarResult();

            $progressBar = new ProgressBar($output, $totalCount);

            $progressBar->start();
        }

        $this->container->get("search.engine")->clearType(VideoConfiguration::$elasticType);

        $iteration = 0;

        $query = $qB->select("video.id")
            ->where("video.status = :videoStatus")
            ->setParameter("videoStatus", "A");

        do {
            $query->setMaxResults($pageSize)->setFirstResult($pageSize * $iteration++);

            $ids = $query->getQuery()->getArrayResult();


            if ($foundCount = count($ids)) {
                array_walk($ids, function (&$value) {
                    $value = $value["id"];
                });

                $this->addUpsert($ids);
                $progressBar and $progressBar->advance($foundCount);
            }

            $doctrine->getManager()->clear();
        } while ($foundCount);

        $progressBar and $progressBar->finish();
    }

    /**
     * @param Video $element
     * @return string
     */
    public function generateDocFromEntity($element)
    {
        if ($categories = $element->getCategories()) {
            $categoryIds = [];

            /* @var $category Videocategory */
            while ($category = array_pop($categories)) {
                $categoryIds[] = $this->container->get("video.category.synchronization")
                    ->normalizeId($category->getId());
            }

            $categoryId = implode(" ", $categoryIds);
        } else {
            $categoryId = null;
        }

       

        /* @var $image Image */
		$entered = $element->getEntered()->format("Y-m-d H:m:s");
		$updated = $element->getUpdated()->format("Y-m-d H:m:s");
        $document =
            [
                "accountId"       => $element->getAccountId(),
                "categoryId"      => $categoryId,
				"description"     => $element->getDescription(),
                "friendlyUrl"     => $element->getFriendlyUrl(),
                "searchInfo"      => [
                    "keyword" => $element->getFulltextsearchKeyword()
                ],
				"status"          => $element->getStatus() == "A",
				"title"           => $element->getTitle(),
                "views"           => $element->getNumberViews(),
				"averageReview"   => $element->getAvgReview(),
				"comments"    => $element->getNumberComments(),
				"file"        => $element->getFile(),
				"mediatype"   => $element->getMediaType(),
				"embedcode"   => $element->getEmbedcode(),
				"entered"     => $entered,
				"updated"     => $updated,
            ];
		
        return $document;
    }

    /**
     * @param Video $video
     * @return Document|null
     */
    public function getUpsertDocument($video)
    {
        $document = null;

        if ($video and is_object($video)) {
            $document = new Document(
                $video->getId(),
                $this->generateDocFromEntity($video),
                $this->container->get($this->getConfigurationService())->getElasticType(),
                $this->container->get("search.engine")->getElasticIndexName()
            );

            $document->setDocAsUpsert(true);
        }

        return $document;
    }

    /**
     * {@inheritdoc}
     */
    public function getUpsertStash()
    {
        $result = [];

        if ($ids = parent::getUpsertStash()) {
            $elements = $this->container->get("doctrine")->getRepository("VideoBundle:Video")->findBy(["id" => $ids]);

            while ($element = array_pop($elements)) {
                $result[] = $this->getUpsertDocument($element);
            }
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function extractFromResult($info)
    {
        return [
				'accountId'       => $info['accountId'],
                'categoryId'      => $info['categoryId'],
				'description'     => $info['description'],
                'friendlyUrl'     => $info['friendlyUrl'],
                'searchInfo'     => [
                    'keyword' => $info['searchInfo.keyword']
                ],
				'status'          => $info['status'],
				'title'           => $info['title'],
                'views'           => $info['views'],
				'averageReview'   => $info['averageReview'],
				'comments'    => $info['comments'],
				'file'        => $info['file'],
				'mediatype'   => $info['mediatype'],
				'embedcode'   => $info['embedcode'],
				'entered'     => $info['entered'],
				'updated'     => $info['updated']
			
        ];
		
		
    }
}
