<?php

namespace ArcaSolutions\VideoBundle\Search;

use ArcaSolutions\CoreBundle\Search\BaseConfiguration;
use ArcaSolutions\CoreBundle\Services\Utility;
use ArcaSolutions\SearchBundle\Events\SearchEvent;
use ArcaSolutions\SearchBundle\Services\SearchBlock;
use ArcaSolutions\SearchBundle\Services\SearchEngine;
use Symfony\Component\DependencyInjection\ContainerInterface;

class VideoConfiguration extends BaseConfiguration
{
    /**
     * @var string|null
     */
    public static $elasticType = "video";
    /**
     * @var string
     */
    protected $moduleUrlName = null;

    function __construct(ContainerInterface $container)
    {
        parent::__construct($container);

        $this->moduleUrlName = $container->getParameter("alias_video_module");
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            'search.global'   => 'registerItem',
            'recent.video'  => 'registerRecent',
            'popular.video' => 'registerPopular',
			'featured.video'    => 'registerFeatured',
        ];
    }

    public function registerItem(SearchEvent $event)
    {
        if (!$where = $event->getWhere()) {
            $this->register($event);
            $qB = SearchEngine::getElasticaQueryBuilder();


            if (!$where and $keyword = Utility::convertArrayToString($this->searchEvent->getKeyword())) {
                $query = $qB->query()->multi_match()
                    ->setQuery($keyword)
                    ->setTieBreaker(0.3)
                    ->setOperator("and")
                    ->setFields([
                        'friendlyUrl^200',
                        'title^1',
                        'searchInfo.keyword^1'
                    ]);
            } else {
                $query = $qB->query()->match_all();
            }
			
            $this->setElasticaQuery(
                $qB->query()->filtered(
				$query,
                    $qB->filter()->bool()
                        ->addMust($qB->filter()->type(self::$elasticType))
                        ->addMust($qB->filter()->term()->setTerm("status", true))
                )
            );
        }
    }
	
	 /**
     * Gets features listings using elasticSearch
     *
     * @param SearchEvent $event
     */
    public function registerFeatured(SearchEvent $event)
    {
        /* registers this video */
        $this->register($event);

        $qb = SearchEngine::getElasticaQueryBuilder();
        /* query */
        $this->setElasticaQuery(
            $qb->query()->filtered(
            /* gets all */
                $qb->query()->match_all(),
                $qb->filter()->bool()
                    /* sets status */
                    ->addMust($qb->filter()->term()->setTerm('status', true))
                    /* excludes previous items using var from SearchBlock */
                    ->addMustNot($qb->filter()->terms()
                        ->setTerms('_id', SearchBlock::$previousItems[self::$elasticType]))
            )
        );
    }

	
	
    public function registerSuggest(SearchEvent $event)
    {
        if (!$event->getKeyword()) {
            $this->register($event);

            $qB = SearchEngine::getElasticaQueryBuilder();

            $this->setElasticaQuery(
                $qB->query()->filtered(
                    $qB->query()->match_all(),
                    $qB->filter()->bool()
                        ->addMust($qB->filter()->term()->setTerm("_type", self::$elasticType))
                        ->addMust($qB->filter()->term()->setTerm("status", true))
                )
            );
        }
    }

    /**
     * @param SearchEvent $searchEvent
     */
    public function registerRecent(SearchEvent $searchEvent)
    {
        /* registers this event */
        $this->register($searchEvent);

        $qb = SearchEngine::getElasticaQueryBuilder();
		$parameterHandler = $this->container->get("search.parameters");
		$parameterHandler->setModules('video');
		$searchEvent->setDefaultSorter($this->container->get("sorter.relevancy"));
		
        /* query */
        $this->setElasticaQuery(
            $qb->query()->filtered(
            /* gets all */
                $qb->query()->match_all(),
                $qb->filter()->bool()
                    /* sets status */
                    ->addMust($qb->filter()->term()->setTerm('status', true))
                    /* excludes previous items using var from SearchBlock */
                    ->addMustNot($qb->filter()->terms()
                        ->setTerms('_id', SearchBlock::$previousItems[self::$elasticType]))
            )
        );
		
    }
	
	/**
     * @param SearchEvent $searchEvent
     */
    public function registerPopular(SearchEvent $searchEvent)
    {
        /* registers this event */
        $this->register($searchEvent);

        $qb = SearchEngine::getElasticaQueryBuilder();

        $searchEvent->setDefaultSorter($this->container->get("sorter.review"));

        /* query */
        $this->setElasticaQuery(
            $qb->query()->filtered(
            /* gets all */
                $qb->query()->match_all(),
                $qb->filter()->bool()
                    /* sets status */
                    ->addMust($qb->filter()->term()->setTerm('status', true))
                    /* excludes previous items using var from SearchBlock */
                    ->addMustNot($qb->filter()->terms()
                        ->setTerms('_id', SearchBlock::$previousItems[self::$elasticType]))
            )
        );
    }

}
