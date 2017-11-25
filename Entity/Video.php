<?php

namespace ArcaSolutions\VideoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use JMS\Serializer\Annotation as Serializer;

/**
 * Video
 *
 * @ORM\Table(name="Video", uniqueConstraints={@ORM\UniqueConstraint(name="friendly_url_2", columns={"friendly_url"})}, indexes={@ORM\Index(name="account_id", columns={"account_id"}), @ORM\Index(name="status", columns={"status"}), @ORM\Index(name="embed_code", columns={"embed_code"}), @ORM\Index(name="title", columns={"title"}), @ORM\Index(name="cat_1_id", columns={"cat_1_id"}), @ORM\Index(name="parcat_1_level1_id", columns={"parcat_1_level1_id"}), @ORM\Index(name="cat_2_id", columns={"cat_2_id"}), @ORM\Index(name="parcat_2_level1_id", columns={"parcat_2_level1_id"}), @ORM\Index(name="cat_3_id", columns={"cat_3_id"}), @ORM\Index(name="parcat_3_level1_id", columns={"parcat_3_level1_id"}), @ORM\Index(name="cat_4_id", columns={"cat_4_id"}), @ORM\Index(name="parcat_4_level1_id", columns={"parcat_4_level1_id"}), @ORM\Index(name="cat_5_id", columns={"cat_5_id"}), @ORM\Index(name="parcat_5_level1_id", columns={"parcat_5_level1_id"}), @ORM\Index(name="fulltextsearch_keyword", columns={"fulltextsearch_keyword"}), @ORM\Index(name="fulltextsearch_where", columns={"fulltextsearch_where"})})
 * @ORM\Entity(repositoryClass="ArcaSolutions\VideoBundle\Repository\VideoRepository")
 */
class Video
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Serializer\Groups({"videoDetail", "Result"})
     */
    private $id;
	/**
     * @var integer
     *
     * @ORM\Column(name="account_id", type="integer", nullable=true)
     */
    private $accountId;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     * @Serializer\Groups({"videoDetail", "Result"})
     */
    private $title;
	 /**
     * @var string
     *
     * @ORM\Column(name="file", type="string", length=255, nullable=false)
     * @Serializer\Groups({"videoDetail", "Result"})
     */
    private $file;
    /**
     * @var string
     *
     * @ORM\Column(name="friendly_url", type="string", length=255, nullable=false)
     */
    private $friendlyUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     * @Serializer\Groups({"videoDetail"})
     */
    private $description;
	
	/**
     * @var integer
     *
     * @ORM\Column(name="avg_review", type="integer", nullable=false)
     * @Serializer\Groups({"Result", "articleDetail"})
     * @Serializer\SerializedName("rating")
     */
    private $avgReview = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="keywords", type="text", nullable=false)
     */
    private $keywords;

    /**
     * @var string
     *
     * @ORM\Column(name="seo_keywords", type="string", length=255, nullable=false)
     */
    private $seoKeywords;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     */
    private $updated = '0000-00-00 00:00:00';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="entered", type="datetime", nullable=true)
     */
    private $entered = '0000-00-00 00:00:00';
    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=1, nullable=false)
     */
    private $status;

 
    /**
     * @var integer
     *
     * @ORM\Column(name="cat_1_id", type="integer", nullable=true)
     */
    private $cat1Id;

    /**
     * @var integer
     *
     * @ORM\Column(name="parcat_1_level1_id", type="integer", nullable=false, options={"default"="0"})
     */
    private $parcat1Level1Id = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="parcat_1_level2_id", type="integer", nullable=false, options={"default"="0"})
     */
    private $parcat1Level2Id = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="parcat_1_level3_id", type="integer", nullable=false, options={"default"="0"})
     */
    private $parcat1Level3Id = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="parcat_1_level4_id", type="integer", nullable=false, options={"default"="0"})
     */
    private $parcat1Level4Id = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="cat_2_id", type="integer", nullable=true)
     */
    private $cat2Id;

    /**
     * @var integer
     *
     * @ORM\Column(name="parcat_2_level1_id", type="integer", nullable=false, options={"default"="0"})
     */
    private $parcat2Level1Id = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="parcat_2_level2_id", type="integer", nullable=false, options={"default"="0"})
     */
    private $parcat2Level2Id = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="parcat_2_level3_id", type="integer", nullable=false, options={"default"="0"})
     */
    private $parcat2Level3Id = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="parcat_2_level4_id", type="integer", nullable=false, options={"default"="0"})
     */
    private $parcat2Level4Id = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="cat_3_id", type="integer", nullable=true)
     */
    private $cat3Id;

    /**
     * @var integer
     *
     * @ORM\Column(name="parcat_3_level1_id", type="integer", nullable=false, options={"default"="0"})
     */
    private $parcat3Level1Id = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="parcat_3_level2_id", type="integer", nullable=false, options={"default"="0"})
     */
    private $parcat3Level2Id = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="parcat_3_level3_id", type="integer", nullable=false, options={"default"="0"})
     */
    private $parcat3Level3Id = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="parcat_3_level4_id", type="integer", nullable=false, options={"default"="0"})
     */
    private $parcat3Level4Id = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="cat_4_id", type="integer", nullable=true)
     */
    private $cat4Id;

    /**
     * @var integer
     *
     * @ORM\Column(name="parcat_4_level1_id", type="integer", nullable=false, options={"default"="0"})
     */
    private $parcat4Level1Id = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="parcat_4_level2_id", type="integer", nullable=false, options={"default"="0"})
     */
    private $parcat4Level2Id = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="parcat_4_level3_id", type="integer", nullable=false, options={"default"="0"})
     */
    private $parcat4Level3Id = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="parcat_4_level4_id", type="integer", nullable=false, options={"default"="0"})
     */
    private $parcat4Level4Id = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="cat_5_id", type="integer", nullable=true)
     */
    private $cat5Id;

    /**
     * @var integer
     *
     * @ORM\Column(name="parcat_5_level1_id", type="integer", nullable=false, options={"default"="0"})
     */
    private $parcat5Level1Id = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="parcat_5_level2_id", type="integer", nullable=false, options={"default"="0"})
     */
    private $parcat5Level2Id = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="parcat_5_level3_id", type="integer", nullable=false, options={"default"="0"})
     */
    private $parcat5Level3Id = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="parcat_5_level4_id", type="integer", nullable=false, options={"default"="0"})
     */
    private $parcat5Level4Id = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="fulltextsearch_keyword", type="text", nullable=false)
     */
    private $fulltextsearchKeyword;

    /**
     * @var string
     *
     * @ORM\Column(name="fulltextsearch_where", type="text", nullable=false)
     */
    private $fulltextsearchWhere;
	/**
     * @var string
     *
     * @ORM\Column(name="embed_code", type="text", nullable=false)
     */
    private $embedcode;

    /**
     * @var integer
     *
     * @ORM\Column(name="number_views", type="integer", nullable=false)
     */
    private $numberViews = '0';
	
	/**
     * @var integer
     *
     * @ORM\Column(name="comments", type="integer", nullable=false)
     */
    private $numberComments = '0';
	
    /**
     * @ORM\ManyToOne(targetEntity="ArcaSolutions\VideoBundle\Entity\Videocategory", fetch="EAGER")
     * @ORM\JoinColumn(name="cat_1_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $category1;

    /**
     * @ORM\ManyToOne(targetEntity="ArcaSolutions\VideoBundle\Entity\Videocategory", fetch="EAGER")
     * @ORM\JoinColumn(name="cat_2_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $category2;

    /**
     * @ORM\ManyToOne(targetEntity="ArcaSolutions\VideoBundle\Entity\Videocategory", fetch="EAGER")
     * @ORM\JoinColumn(name="cat_3_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $category3;

    /**
     * @ORM\ManyToOne(targetEntity="ArcaSolutions\VideoBundle\Entity\Videocategory", fetch="EAGER")
     * @ORM\JoinColumn(name="cat_4_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $category4;

    /**
     * @ORM\ManyToOne(targetEntity="ArcaSolutions\VideoBundle\Entity\Videocategory", fetch="EAGER")
     * @ORM\JoinColumn(name="cat_5_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $category5;

    /**
     * @Serializer\Groups({"Result"})
     * @var
     */
    private $videoUrl;
	
	/**
     * @var string
     *
     * @ORM\Column(name="media_type", type="string", length=255, nullable=true)
     */
    private $mediatype;

    /**
     * @var string
     * @Serializer\Groups({"videoDetail"})
     */
    private $detailUrl;

    /**
     * @return mixed
     */
    public function getVideoUrl()
    {
        return $this->videoUrl;
    }

    /**
     * @param mixed $imageUrl
     */
    public function setVideoUrl($imageUrl)
    {
        $this->videoUrl = $videoUrl;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

   
    /**
     * Set accountId
     *
     * @param integer $accountId
     *
     * @return Video
     */
    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;

        return $this;
    }

    /**
     * Get accountId
     *
     * @return integer
     */
    public function getAccountId()
    {
        return $this->accountId;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Video
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
	
	/**
		* Set file
     *
     * @param string $title
     * @return Video
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }
	
	
	/**
		* Set MediaType
     *
     * @param string $mediatype
     * @return Video
     */
    public function setMediaType($mediatype)
    {
        $this->mediatype = $mediatype;

        return $this;
    }

    /**
     * Get MediaType
     *
     * @return string
     */
    public function getMediaType()
    {
        return $this->mediatype;
    }
	
    /**
     * Set friendlyUrl
     *
     * @param string $friendlyUrl
     * @return Video
     */
    public function setFriendlyUrl($friendlyUrl)
    {
        $this->friendlyUrl = $friendlyUrl;

        return $this;
    }

    /**
     * Get friendlyUrl
     *
     * @return string
     */
    public function getFriendlyUrl()
    {
        return $this->friendlyUrl;
    }
	
	
    /**
     * Set avgReview
     *
     * @param integer $avgReview
     * @return Article
     */
    public function setAvgReview($avgReview)
    {
        $this->avgReview = $avgReview;

        return $this;
    }

    /**
     * Get avgReview
     *
     * @return integer
     */
    public function getAvgReview()
    {
        return $this->avgReview;
    }

	
    /**
     * Set description
     *
     * @param string $description
     * @return Video
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set keywords
     *
     * @param string $keywords
     * @return Video
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;

        return $this;
    }

    /**
     * Get keywords
     *
     * @return string
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Set seoKeywords
     *
     * @param string $seoKeywords
     * @return Video
     */
    public function setSeoKeywords($seoKeywords)
    {
        $this->seoKeywords = $seoKeywords;

        return $this;
    }

    /**
     * Get seoKeywords
     *
     * @return string
     */
    public function getSeoKeywords()
    {
        return $this->seoKeywords;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Video
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set entered
     *
     * @param \DateTime $entered
     * @return Video
     */
    public function setEntered($entered)
    {
        $this->entered = $entered;

        return $this;
    }

    /**
     * Get entered
     *
     * @return \DateTime
     */
    public function getEntered()
    {
        return $this->entered;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Video
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set cat1Id
     *
     * @param integer $cat1Id
     * @return Video
     */
    public function setCat1Id($cat1Id)
    {
        $this->cat1Id = $cat1Id;

        return $this;
    }

    /**
     * Get cat1Id
     *
     * @return integer
     */
    public function getCat1Id()
    {
        return $this->cat1Id;
    }

    /**
     * Set parcat1Level1Id
     *
     * @param integer $parcat1Level1Id
     * @return Video
     */
    public function setParcat1Level1Id($parcat1Level1Id)
    {
        $this->parcat1Level1Id = $parcat1Level1Id;

        return $this;
    }

    /**
     * Get parcat1Level1Id
     *
     * @return integer
     */
    public function getParcat1Level1Id()
    {
        return $this->parcat1Level1Id;
    }

    /**
     * Set parcat1Level2Id
     *
     * @param integer $parcat1Level2Id
     * @return Video
     */
    public function setParcat1Level2Id($parcat1Level2Id)
    {
        $this->parcat1Level2Id = $parcat1Level2Id;

        return $this;
    }

    /**
     * Get parcat1Level2Id
     *
     * @return integer
     */
    public function getParcat1Level2Id()
    {
        return $this->parcat1Level2Id;
    }

    /**
     * Set parcat1Level3Id
     *
     * @param integer $parcat1Level3Id
     * @return Video
     */
    public function setParcat1Level3Id($parcat1Level3Id)
    {
        $this->parcat1Level3Id = $parcat1Level3Id;

        return $this;
    }

    /**
     * Get parcat1Level3Id
     *
     * @return integer
     */
    public function getParcat1Level3Id()
    {
        return $this->parcat1Level3Id;
    }

    /**
     * Set parcat1Level4Id
     *
     * @param integer $parcat1Level4Id
     * @return Video
     */
    public function setParcat1Level4Id($parcat1Level4Id)
    {
        $this->parcat1Level4Id = $parcat1Level4Id;

        return $this;
    }

    /**
     * Get parcat1Level4Id
     *
     * @return integer
     */
    public function getParcat1Level4Id()
    {
        return $this->parcat1Level4Id;
    }

    /**
     * Set cat2Id
     *
     * @param integer $cat2Id
     * @return Video
     */
    public function setCat2Id($cat2Id)
    {
        $this->cat2Id = $cat2Id;

        return $this;
    }

    /**
     * Get cat2Id
     *
     * @return integer
     */
    public function getCat2Id()
    {
        return $this->cat2Id;
    }

    /**
     * Set parcat2Level1Id
     *
     * @param integer $parcat2Level1Id
     * @return Video
     */
    public function setParcat2Level1Id($parcat2Level1Id)
    {
        $this->parcat2Level1Id = $parcat2Level1Id;

        return $this;
    }

    /**
     * Get parcat2Level1Id
     *
     * @return integer
     */
    public function getParcat2Level1Id()
    {
        return $this->parcat2Level1Id;
    }

    /**
     * Set parcat2Level2Id
     *
     * @param integer $parcat2Level2Id
     * @return Video
     */
    public function setParcat2Level2Id($parcat2Level2Id)
    {
        $this->parcat2Level2Id = $parcat2Level2Id;

        return $this;
    }

    /**
     * Get parcat2Level2Id
     *
     * @return integer
     */
    public function getParcat2Level2Id()
    {
        return $this->parcat2Level2Id;
    }

    /**
     * Set parcat2Level3Id
     *
     * @param integer $parcat2Level3Id
     * @return Video
     */
    public function setParcat2Level3Id($parcat2Level3Id)
    {
        $this->parcat2Level3Id = $parcat2Level3Id;

        return $this;
    }

    /**
     * Get parcat2Level3Id
     *
     * @return integer
     */
    public function getParcat2Level3Id()
    {
        return $this->parcat2Level3Id;
    }

    /**
     * Set parcat2Level4Id
     *
     * @param integer $parcat2Level4Id
     * @return Video
     */
    public function setParcat2Level4Id($parcat2Level4Id)
    {
        $this->parcat2Level4Id = $parcat2Level4Id;

        return $this;
    }

    /**
     * Get parcat2Level4Id
     *
     * @return integer
     */
    public function getParcat2Level4Id()
    {
        return $this->parcat2Level4Id;
    }

    /**
     * Set cat3Id
     *
     * @param integer $cat3Id
     * @return Video
     */
    public function setCat3Id($cat3Id)
    {
        $this->cat3Id = $cat3Id;

        return $this;
    }

    /**
     * Get cat3Id
     *
     * @return integer
     */
    public function getCat3Id()
    {
        return $this->cat3Id;
    }

    /**
     * Set parcat3Level1Id
     *
     * @param integer $parcat3Level1Id
     * @return Video
     */
    public function setParcat3Level1Id($parcat3Level1Id)
    {
        $this->parcat3Level1Id = $parcat3Level1Id;

        return $this;
    }

    /**
     * Get parcat3Level1Id
     *
     * @return integer
     */
    public function getParcat3Level1Id()
    {
        return $this->parcat3Level1Id;
    }

    /**
     * Set parcat3Level2Id
     *
     * @param integer $parcat3Level2Id
     * @return Video
     */
    public function setParcat3Level2Id($parcat3Level2Id)
    {
        $this->parcat3Level2Id = $parcat3Level2Id;

        return $this;
    }

    /**
     * Get parcat3Level2Id
     *
     * @return integer
     */
    public function getParcat3Level2Id()
    {
        return $this->parcat3Level2Id;
    }

    /**
     * Set parcat3Level3Id
     *
     * @param integer $parcat3Level3Id
     * @return Video
     */
    public function setParcat3Level3Id($parcat3Level3Id)
    {
        $this->parcat3Level3Id = $parcat3Level3Id;

        return $this;
    }

    /**
     * Get parcat3Level3Id
     *
     * @return integer
     */
    public function getParcat3Level3Id()
    {
        return $this->parcat3Level3Id;
    }

    /**
     * Set parcat3Level4Id
     *
     * @param integer $parcat3Level4Id
     * @return Video
     */
    public function setParcat3Level4Id($parcat3Level4Id)
    {
        $this->parcat3Level4Id = $parcat3Level4Id;

        return $this;
    }

    /**
     * Get parcat3Level4Id
     *
     * @return integer
     */
    public function getParcat3Level4Id()
    {
        return $this->parcat3Level4Id;
    }

    /**
     * Set cat4Id
     *
     * @param integer $cat4Id
     * @return Video
     */
    public function setCat4Id($cat4Id)
    {
        $this->cat4Id = $cat4Id;

        return $this;
    }

    /**
     * Get cat4Id
     *
     * @return integer
     */
    public function getCat4Id()
    {
        return $this->cat4Id;
    }

    /**
     * Set parcat4Level1Id
     *
     * @param integer $parcat4Level1Id
     * @return Video
     */
    public function setParcat4Level1Id($parcat4Level1Id)
    {
        $this->parcat4Level1Id = $parcat4Level1Id;

        return $this;
    }

    /**
     * Get parcat4Level1Id
     *
     * @return integer
     */
    public function getParcat4Level1Id()
    {
        return $this->parcat4Level1Id;
    }

    /**
     * Set parcat4Level2Id
     *
     * @param integer $parcat4Level2Id
     * @return Video
     */
    public function setParcat4Level2Id($parcat4Level2Id)
    {
        $this->parcat4Level2Id = $parcat4Level2Id;

        return $this;
    }

    /**
     * Get parcat4Level2Id
     *
     * @return integer
     */
    public function getParcat4Level2Id()
    {
        return $this->parcat4Level2Id;
    }

    /**
     * Set parcat4Level3Id
     *
     * @param integer $parcat4Level3Id
     * @return Video
     */
    public function setParcat4Level3Id($parcat4Level3Id)
    {
        $this->parcat4Level3Id = $parcat4Level3Id;

        return $this;
    }

    /**
     * Get parcat4Level3Id
     *
     * @return integer
     */
    public function getParcat4Level3Id()
    {
        return $this->parcat4Level3Id;
    }

    /**
     * Set parcat4Level4Id
     *
     * @param integer $parcat4Level4Id
     * @return Video
     */
    public function setParcat4Level4Id($parcat4Level4Id)
    {
        $this->parcat4Level4Id = $parcat4Level4Id;

        return $this;
    }

    /**
     * Get parcat4Level4Id
     *
     * @return integer
     */
    public function getParcat4Level4Id()
    {
        return $this->parcat4Level4Id;
    }

    /**
     * Set cat5Id
     *
     * @param integer $cat5Id
     * @return Video
     */
    public function setCat5Id($cat5Id)
    {
        $this->cat5Id = $cat5Id;

        return $this;
    }

    /**
     * Get cat5Id
     *
     * @return integer
     */
    public function getCat5Id()
    {
        return $this->cat5Id;
    }

    /**
     * Set parcat5Level1Id
     *
     * @param integer $parcat5Level1Id
     * @return Video
     */
    public function setParcat5Level1Id($parcat5Level1Id)
    {
        $this->parcat5Level1Id = $parcat5Level1Id;

        return $this;
    }

    /**
     * Get parcat5Level1Id
     *
     * @return integer
     */
    public function getParcat5Level1Id()
    {
        return $this->parcat5Level1Id;
    }

    /**
     * Set parcat5Level2Id
     *
     * @param integer $parcat5Level2Id
     * @return Video
     */
    public function setParcat5Level2Id($parcat5Level2Id)
    {
        $this->parcat5Level2Id = $parcat5Level2Id;

        return $this;
    }

    /**
     * Get parcat5Level2Id
     *
     * @return integer
     */
    public function getParcat5Level2Id()
    {
        return $this->parcat5Level2Id;
    }

    /**
     * Set parcat5Level3Id
     *
     * @param integer $parcat5Level3Id
     * @return Video
     */
    public function setParcat5Level3Id($parcat5Level3Id)
    {
        $this->parcat5Level3Id = $parcat5Level3Id;

        return $this;
    }

    /**
     * Get parcat5Level3Id
     *
     * @return integer
     */
    public function getParcat5Level3Id()
    {
        return $this->parcat5Level3Id;
    }

    /**
     * Set parcat5Level4Id
     *
     * @param integer $parcat5Level4Id
     * @return Video
     */
    public function setParcat5Level4Id($parcat5Level4Id)
    {
        $this->parcat5Level4Id = $parcat5Level4Id;

        return $this;
    }

    /**
     * Get parcat5Level4Id
     *
     * @return integer
     */
    public function getParcat5Level4Id()
    {
        return $this->parcat5Level4Id;
    }

    /**
     * Set fulltextsearchKeyword
     *
     * @param string $fulltextsearchKeyword
     * @return Video
     */
    public function setFulltextsearchKeyword($fulltextsearchKeyword)
    {
        $this->fulltextsearchKeyword = $fulltextsearchKeyword;

        return $this;
    }

    /**
     * Get fulltextsearchKeyword
     *
     * @return string
     */
    public function getFulltextsearchKeyword()
    {
        return $this->fulltextsearchKeyword;
    }

    /**
     * Set fulltextsearchWhere
     *
     * @param string $fulltextsearchWhere
     * @return Video
     */
    public function setFulltextsearchWhere($fulltextsearchWhere)
    {
        $this->fulltextsearchWhere = $fulltextsearchWhere;

        return $this;
    }

    /**
     * Get fulltextsearchWhere
     *
     * @return string
     */
    public function getFulltextsearchWhere()
    {
        return $this->fulltextsearchWhere;
    }
	
	/**
     * Set embedcode
     *
     * @param string $fulltextsearchWhere
     * @return Video
     */
    public function setEmbedcode($embedcode)
    {
        $this->embedcode = $embedcode;

        return $this;
    }

    /**
     * Get embedcode
     *
     * @return string
     */
    public function getEmbedcode()
    {
        return $this->embedcode;
    }
	 /**
     * Set numberComments
     *
     * @param integer $numberViews
     * @return Video
     */
    public function setNumberComments($numberComments)
    {
        $this->numberComments = $numberComments;

        return $this;
    }

    /**
     * Get numberViews
     *
     * @return integer
     */
    public function getNumberComments()
    {
        return $this->numberComments;
    }
	
    /**
     * Set numberViews
     *
     * @param integer $numberViews
     * @return Video
     */
    public function setNumberViews($numberViews)
    {
        $this->numberViews = $numberViews;

        return $this;
    }

    /**
     * Get numberViews
     *
     * @return integer
     */
    public function getNumberViews()
    {
        return $this->numberViews;
    }

    /**
     * @return mixed
     */
    public function getCategory1()
    {
        return $this->category1;
    }

    /**
     * @param mixed $category1
     */
    public function setCategory1($category1)
    {
        $this->category1 = $category1;
    }

    /**
     * @return mixed
     */
    public function getCategory2()
    {
        return $this->category2;
    }

    /**
     * @param mixed $category2
     */
    public function setCategory2($category2)
    {
        $this->category2 = $category2;
    }

    /**
     * @return mixed
     */
    public function getCategory3()
    {
        return $this->category3;
    }

    /**
     * @param mixed $category3
     */
    public function setCategory3($category3)
    {
        $this->category3 = $category3;
    }

    /**
     * @return mixed
     */
    public function getCategory5()
    {
        return $this->category5;
    }

    /**
     * @param mixed $category5
     */
    public function setCategory5($category5)
    {
        $this->category5 = $category5;
    }

    /**
     * @return mixed
     */
    public function getCategory4()
    {
        return $this->category4;
    }

    /**
     * @param mixed $category4
     */
    public function setCategory4($category4)
    {
        $this->category4 = $category4;
    }

    /**
     * Get all categories related to an video
     *
     * @Serializer\VirtualProperty()
     * @Serializer\SerializedName("categories")
     * @Serializer\Groups({"videoDetail"})
     *
     * @return array
     */
    public function getCategories()
    {
        $categories_array = [];

        for ($i = 1; $i <= 5; $i++) {
            if (0 < $this->{'cat' . $i . 'Id'}) {
                $cat = $this->{'category' . $i};
				if($cat){
                if ($cat->getEnabled() == 'n')
                    continue;

                $categories_array[] = $cat;
				}
            }
        }

        return $categories_array;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getDetailUrl()
    {
        return $this->detailUrl;
    }

    /**
     * @param string $detailUrl
     */
    public function setDetailUrl($detailUrl)
    {
        $this->detailUrl = $detailUrl;
    }


}
