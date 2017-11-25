<?php

namespace ArcaSolutions\VideoBundle\Controller;

use ArcaSolutions\VideoBundle\VideoItemDetail;
use ArcaSolutions\VideoBundle\Entity\Video;
use ArcaSolutions\VideoBundle\Entity\Videocategory;
use ArcaSolutions\VideoBundle\Sample\VideoSample;
use ArcaSolutions\CoreBundle\Exception\ItemNotFoundException;
use ArcaSolutions\CoreBundle\Exception\UnavailableItemException;
use ArcaSolutions\CoreBundle\Services\ValidationDetail;
use ArcaSolutions\ReportsBundle\Services\ReportHandler;
use ArcaSolutions\SearchBundle\Entity\Elasticsearch\Category;
use ArcaSolutions\SearchBundle\Services\ParameterHandler;
use ArcaSolutions\SearchBundle\Entity\Summary\SummaryTitle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use OpenTok\OpenTok;


class DefaultController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('::modules/video/index.html.twig', [
            'title' => 'Video Index',
        ]);
    }
	
	/**
		* @return \Symfony\Component\HttpFoundation\Response
	*/
    public function archivedAction($page)
    {
		//exit;
		$request = $this->get("request_stack")->getCurrentRequest();
		$parameterHandler = $this->get("search.parameters");
		$searchEngine = $this->get('search.engine');
		$reportHandler = $this->get("reporthandler");
		$JSHandler = $this->get("javascripthandler");
		$page = $searchEngine->convertFromPaginationFormat($page);
		
		if (!$this->container->get('modules')->isModuleAvailable('event')) {
            return '';
        }
		$limit = $page*3;
		$em = $this->container->get('doctrine')->getManager(); // ...or getEntityManager() prior to Symfony 2.1
		$connection = $em->getConnection();
		$statement = $connection->prepare("SELECT * FROM ArchiveList ORDER BY id DESC");
		
		
		$statement->execute();
		$results = $statement->fetchAll();
		
		$where = null;
        $whereInfo = json_decode($request->cookies->get("edirectory_searchQuery_where_internal", null), true);

        if (is_array($whereInfo) and array_key_exists("setBy", $whereInfo) and $whereInfo["setBy"] == "user") {
            $where = $request->cookies->get("edirectory_searchQuery_where_typed", null);
        }
		$parameterHandler->setModules('event');
		if ($keyword = implode(" ", $parameterHandler->getKeywords())) {
            $modules = $parameterHandler->hasModules() ? $parameterHandler->getModules() : ['event'];
			
            foreach ($modules as $module) {
                $reportHandler->addKeywordSearchReport($reportHandler->getReportModule($module), $keyword, $where);
            }
        }
		$searchEvent = $searchEngine->globalSearch($keyword, $where);
		$searchEngine->search($searchEvent);
		$apiKey = $this->container->get('settings')->getDomainSetting('opentok_api');
		$secret = $this->container->get('settings')->getDomainSetting('opentok_secret');

		$opentok = new OpenTok($apiKey, $secret);
		
		
		$items = array();
		$url = array();
		$i=0;
		foreach($results as $result)
		{
			$items[] = $this->container->get('doctrine')->getRepository('EventBundle:Event')->find(array('id'=>$result['event_id']));
			
			$archive = $opentok->getArchive($result['archive_id']);
			
			$url['archive_'.$i.$result['event_id']]=$archive->url;
			$i++;
		}
		
		
		
		$search = $searchEngine->search($searchEvent);
		
		$paginations = $this->get('knp_paginator')->paginate($search, $page);
		$pagination = $this->get('knp_paginator')->paginate($items, $page, 6);
		$searchEvent->processAggregationResults($paginations);

        /* Sets module level information to be used while rendering the summary templates */
        $levels = $searchEvent->getModuleLevelFeatures();

        /* Adds the required Javascript to enable module results interaction */
        foreach ($searchEvent->getResultsJSTwigs() as $pathToTwig) {
            $JSHandler->addJSBlock($pathToTwig);
        }
		$parameterHandlerCanonical = clone $parameterHandler;
        $parameterHandlerCanonical->clearAllQueryParameters();
		$previousPage = $page > 1 ? $parameterHandler->buildUrl($page - 1) : null;
        $nextPage = $page < $pagination->getPageCount() ? $parameterHandler->buildUrl($page + 1) : null;
		
		
        return $this->render('::modules/video/archived.html.twig', [
			'previousPage' => $previousPage,
            'nextPage'     => $nextPage,
			'canonical'    => $parameterHandlerCanonical->buildUrl(),
            'items' => $pagination,
            'class' => $class,
            'grid' => $grid,
			'url'   => $url,
			'searchEvent'  => $searchEvent,
        ]);
    }
	
    /**
     * @param $friendlyUrl
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws ItemNotFoundException
     * @throws \Exception
     */
    public function detailAction($friendlyUrl)
    {
        /*
         * Validation
         */
        /* @var $item Video For phpstorm get properties of entity Video */
        $item = $this->get('search.engine')->itemFriendlyURL($friendlyUrl, 'video', 'VideoBundle:Video');
		//print_r($item); exit;
        /* event not found by friendlyURL */
        if (is_null($item)) {
            throw new ItemNotFoundException();
        }
		
        /* Gets profile image from main DB */
        //if ($account = $item->getAccount()) {
            /* sets profile image manually because doctrine can't make a relationship using tables from another DB  */
            //$account->profileImage = $this->get('profile.image.service')->getProfileImage($account);
            //$item->setAccount($account);
        //}
		$doctrine = $this->container->get("doctrine");
        $this->container->get("reporthandler")->increaseNumberViewsVideo($doctrine->getRepository('VideoBundle:Video')->find($item->getId()));
        $this->container->get("video.synchronization")->addUpsert($item->getId());
		//echo "<pre>";
		//print_r($item); exit;
        //$categoryIds = array_map(function ($item) {
            /* @var $item VideoCategory */
            //return new Category($item->getId(), null, null, ParameterHandler::MODULE_VIDEO, null, null, null, null, null);
        //}, $item->getCategories());
		
		$request = $this->container->get('request');  
		$userid = $request->getSession()->get('SESS_ACCOUNT_ID');
		//echo "<pre>";
		//print_r($item); exit;
        return $this->render('::modules/video/detail.html.twig', [
            //'bannerCategories' => $categoryIds,
            'item'             => $item,
            'categories'       => $item->getCategories(),
			'userid'           => $userid,
        ]);
    }

    /**
     * @param int $level
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     * @throws \Ivory\GoogleMap\Exception\MapException
     * @throws \Ivory\GoogleMap\Exception\OverlayException
     */
    public function sampleDetailAction($level = 0)
    {
        $item = new VideoSample($level, $this->get("translator"), $this->get('doctrine'));
        $videoItemDetail = new VideoItemDetail($this->container, $item);

        /* Validates if video has the review active */
        $reviews_active = $this->getDoctrine()->getRepository('WebBundle:Setting')
            ->getSetting('review_video_enabled');

        return $this->render('::modules/video/detail.html.twig', [
            'item'           => $item,
            'categories'     => $item->getCategories(),
            'isSample'       => true
        ]);
    }
	
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function allcategoriesAction()
    {
        $categories = $this->getDoctrine()
            ->getRepository('VideoBundle:Videocategory')
            ->getHierarchyCategories(null, 1);

        usort($categories, function ($a, $b) {
            /* @var $a Videocategory */
            /* @var $b Videocategory */
            return strcmp($a->getTitle(), $b->getTitle());
        });

        $data = [
            'categories' => $categories,
            'routing'    => ParameterHandler::MODULE_VIDEO,
        ];

        $response = $this->render('::modules/video/all-categories.html.twig', $data);

        return $response;
    }
}
