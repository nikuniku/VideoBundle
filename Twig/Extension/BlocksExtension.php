<?php
namespace ArcaSolutions\VideoBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;

class BlocksExtension extends \Twig_Extension
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface $containerInterface
     */
    public function __construct(ContainerInterface $containerInterface)
    {
        $this->container = $containerInterface;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('recentVideo', [$this, 'recentVideo'], [
                'needs_environment' => true,
                'is_safe' => ['html']
            ]),
			new \Twig_SimpleFunction('popularVideo', [$this, 'popularVideo'], [
                'needs_environment' => true,
                'is_safe' => ['html']
            ]),
			new \Twig_SimpleFunction('getcomments', [$this, 'getcomments'], [
                'needs_environment' => true,
                'is_safe' => ['html']
            ]),
			new \Twig_SimpleFunction('vedio_parser', [$this, 'vedio_parser'], [
                'needs_environment' => true,
                'is_safe' => ['html']
            ]),
			new \Twig_SimpleFunction('recentVideoHome', [$this, 'recentVideoHome'], [
                'needs_environment' => true,
                'is_safe' => ['html']
            ])
        ];
    }

    /**
     * @param \Twig_Environment $twig_Environment
     * @param int $quantity
     * @param string $class
     * @param string $grid
     *
     * @return string
     */
    public function recentVideo(\Twig_Environment $twig_Environment, $quantity = 4, $class = '', $grid = 'vertical')
    {
        if (!$this->container->get('modules')->isModuleAvailable('video')) {
            return '';
        }
		
        $items = $this->container->get('search.block')->getRecent('video', $quantity);
		//echo "<pre>";
		//print_r($items); exit;
        if (!$items) {
            return '';
        }

        return $twig_Environment->render('::modules/video/blocks/recent.html.twig', [
            'items' => $items,
            'class' => $class,
            'grid' => $grid
        ]);
    }
	
	/**
	* @param \Twig_Environment $twig_Environment
     * @param int $quantity
     * @param string $class
     * @param string $grid
     *
     * @return string
     */
    public function recentVideoHome(\Twig_Environment $twig_Environment, $quantity = 4, $class = '', $grid = 'vertical')
    {
        if (!$this->container->get('modules')->isModuleAvailable('video')) {
            return '';
        }
		
        $items = $this->container->get('search.block')->getRecent('video', $quantity);
		//echo "<pre>";
		//print_r($items); exit;
        if (!$items) {
            return '';
        }
		
		if($quantity==1){
				return $twig_Environment->render('::modules/video/blocks/bigsizevideos.html.twig', [
				'items' => $items,
				'class' => $class,
				'grid' => $grid
				]);
			} else 
			{
				return $twig_Environment->render('::modules/video/blocks/videos.html.twig', [
				'items' => $items,
				'class' => $class,
				'grid' => $grid
				]);
			}
    }
	
	/**
     * @param \Twig_Environment $twig_Environment
     * @param int $quantity
     * @param string $class
     * @param string $grid
     *
     * @return string
     */
    public function popularVideo(\Twig_Environment $twig_Environment, $quantity = 4, $class = '', $grid = 'vertical')
    {
        if (!$this->container->get('modules')->isModuleAvailable('video')) {
            return '';
        }
		
        $items = $this->container->get('search.block')->getPopular('video', $quantity);
		//echo "<pre>";
		//print_r($items); exit;
        if (!$items) {
            return '';
        }

        return $twig_Environment->render('::modules/video/blocks/popular.html.twig', [
            'items' => $items,
            'class' => $class,
            'grid' => $grid
        ]);
    }
	
	/**
	* @param \Twig_Environment $twig_Environment
     * @param int $id
     * @param string $class
     * @param string $grid
     *
     * @return string
     */
	public function getcomments(\Twig_Environment $twig_Environment, $id=0)
    {
		$request = $this->container->get('request');
		$em = $this->container->get("doctrine");
		$connection = $em->getConnection();
		$statement = $connection->prepare("SELECT Video_Comments.*,AccountProfileContact.* FROM Video_Comments LEFT JOIN AccountProfileContact ON AccountProfileContact.account_id=Video_Comments.user_id WHERE media_id=$id ORDER BY id DESC");-
		$statement->execute();
		$items = $statement->fetchAll();
        if (!$items) {
            return '';
        }
		$userid = $request->getSession()->get('SESS_ACCOUNT_ID');
		//echo "<pre>";
		//print_r($items); exit;
		$count = count($items);
		return $twig_Environment->render('::blocks/comment.html.twig', [
			'items' => $items,
			'countcomment' => $count,
			'userid'       =>$userid,
		]);
    }
	
	/**
     * @param \Twig_Environment $twig_Environment
     * @param int $quantity
     * @param string $class
     * @param string $grid
     *
     * @return string
     */
	function vedio_parser(\Twig_Environment $twig_Environment, $url,$autoplay = false,$wdth=320,$hth=320){
			if($autoplay){
			$auto = '?autoplay=1';
			}
			
			
		if (strpos($url, 'youtube.com') !== FALSE) {

		$step1=explode('v=', $url);
		$step2 =explode('&amp;',$step1[1]);
		$iframe ='<iframe width="'.$wdth.'" height="'.$hth.'" src="http://www.youtube.com/embed/'.$step2[0].'" frameborder="0"></iframe>';
		$embed ='<object width="'.$wdth.'" height="'.$hth.'" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0"><param name="src" value="http://www.youtube.com/v/'.$step2[0].'&'.$auto.'" /><param name="wmode" value="transparent" /><param name="embed" value="" /><embed width="'.$wdth.'" height="'.$hth.'" type="application/x-shockwave-flash" src="http://www.youtube.com/v/'.$step2[0].$auto2.'" wmode="transparent" embed="" /></object>';

		$thumbnail_str = 'http://img.youtube.com/vi/'.$step2[0].'/0.jpg';
		$fullsize_str = '<img class="media-object" src="http://img.youtube.com/vi/'.$step2[0].'/0.jpg" />';

		} else if(strpos($url, 'youtu.be') !== FALSE){
			if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
				$step2 = $match[1];
			}
			
			$iframe ='<iframe width="'.$wdth.'" height="'.$hth.'" src="http://www.youtube.com/embed/'.$step2.'" frameborder="0"></iframe>';
			$embed ='<object width="'.$wdth.'" height="'.$hth.'" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0"><param name="src" value="http://www.youtube.com/v/'.$step2.'&'.$auto.'" /><param name="wmode" value="transparent" /><param name="embed" value="" /><embed width="'.$wdth.'" height="'.$hth.'" type="application/x-shockwave-flash" src="http://www.youtube.com/v/'.$step2.$auto2.'" wmode="transparent" embed="" /></object>';

			$thumbnail_str = 'http://img.youtube.com/vi/'.$step2.'/0.jpg';
			$fullsize_str = '<img class="media-object" src="http://img.youtube.com/vi/'.$step2.'/0.jpg" />';
		} else if (strpos($url, 'vimeo') !== FALSE) { 

		$id=str_replace('https://vimeo.com/','',$url);
		$embedurl = "https://player.vimeo.com/video/".$id;

$iframe = '<iframe  src="'.$embedurl.'"
		 width="'.$wdth.'" height="'.$hth.'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen>
		</iframe>';
		$embed ='
		<embed width="'.$wdth.'" height="'.$hth.'" type="application/x-shockwave-flash" 
		src="'.$embedurl.'"  />
		';
		$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$id.php"));
		if (!empty($hash) && is_array($hash)) {
		//$video_str = 'http://vimeo.com/moogaloop.swf?clip_id=%s';
		$thumbnail_str = $hash[0]['thumbnail_large'];
		$fullsize_str = '<img class="media-object" src="'.$hash[0]['thumbnail_large'].'" />';

		}

		}	
			

		return array("embed"=>$iframe,"thumb_image" =>$fullsize_str, "thumb_source"=>$thumbnail_str);	

		}
	
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'blocks_video';
    }
}
