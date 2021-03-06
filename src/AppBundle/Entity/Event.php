<?php

namespace AppBundle\Entity;

use AppBundle\Entity\EventHour;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EventRepository")
 */
class Event
{
	
	/**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="events")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     */
    private $author;
	
	/**
     * @ORM\OneToMany(targetEntity="EventHour", mappedBy="event")
	 * @ORM\OrderBy({"day" = "ASC", "start" = "ASC", "end" = "ASC"})
     */
    private $eventHours;
	
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
	 * @Assert\NotBlank()
     * @ORM\Column(name="title", type="string", length=255, unique=true)
     */
    private $title;
	
	/**
     * @var int
     *
     * @ORM\Column(name="author_id", type="integer")
     */
    private $authorId;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;
	
	public function __construct()
    {
        $this->eventHours = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Event
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
     * Set description
     *
     * @param string $description
     *
     * @return Event
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
	
	public function getDescriptionLength()
	{
		return strlen($this->getDescription());
	}
	
	/**
     * Set eventHours
     *
     * @param ArrayCollection $eventHours
     *
     * @return Event
     */
    public function setEventHours($eventHours)
    {
        $this->eventHours = $eventHours;

        return $this;
    }

    /**
     * Get eventHours
     *
     * @return ArrayCollection
     */
    public function getEventHours()
    {
        return $this->eventHours;
    }
	
	/**
     * Set authorId
     *
     * @param integer $authorId
     *
     * @return Event
     */
    public function setAuthorId($authorId)
    {
        $this->authorId = $authorId;

        return $this;
    }

    /**
     * Get authorId
     *
     * @return int
     */
    public function getAuthorId()
    {
        return $this->authorId;
    }
	
	/**
     * Set author
     *
     * @param User $author
     *
     * @return Event
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }
	
	/**
     * Get author
     *
     * @return User
     */
    public function getAuthor()
    {
        return $this->author;
    }
	
}

