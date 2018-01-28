<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EventHour
 *
 * @ORM\Table(name="event_hour")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EventHourRepository")
 */
class EventHour
{
	/**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="eventHours")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     */
    private $author;
	
	/**
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="eventHours")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
     */
    private $event;
	
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \Time
     *
     * @ORM\Column(name="start", type="time")
     */
    private $start;

    /**
     * @var \Time
     *
     * @ORM\Column(name="end", type="time")
     */
    private $end;
	
	/**
     * @var int
     *
     * @ORM\Column(name="day", type="integer")
     */
    private $day;
	
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="event_id", type="integer")
     */
    private $eventId;
	
	/**
     * @var int
     *
     * @ORM\Column(name="author_id", type="integer")
     */
    private $authorId;

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
     * Set start
     *
     * @param \Time $start
     *
     * @return EventHour
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start
     *
     * @return \Time
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set end
     *
     * @param \Time $end
     *
     * @return EventHour
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Get end
     *
     * @return \Time
     */
    public function getEnd()
    {
        return $this->end;
    }
	
    /**
     * Set description
     *
     * @param string $description
     *
     * @return EventHour
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
     * Set day
     *
     * @param integer $day
     *
     * @return EventHour
     */
    public function setDay($day)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Get day
     *
     * @return int
     */
    public function getDay()
    {
        return $this->day;
    }

	/**
     * Get day name
     *
     * @return string
     */
    public function getDayName()
    {
		$dayName = '';
		
		switch($this->day) {
			case 1: 
				$dayName = 'Monday';
				break;
			case 2: 
				$dayName = 'Tuesday';
				break;
			case 3: 
				$dayName = 'Wednesday';
				break;
			case 4: 
				$dayName = 'Thursday';
				break;
			case 5: 
				$dayName = 'Friday';
				break;
			case 6: 
				$dayName = 'Saturday';
				break;
			case 7: 
				$dayName = 'Sunday';
				break;
		}
		
        return $dayName;
    }
	
    /**
     * Set eventId
     *
     * @param integer $eventId
     *
     * @return EventHour
     */
    public function setEventId($eventId)
    {
        $this->eventId = $eventId;

        return $this;
    }

    /**
     * Get eventId
     *
     * @return int
     */
    public function getEventId()
    {
        return $this->eventId;
    }
	
	/**
     * Set event
     *
     * @param Event $event
     *
     * @return EventHour
     */
    public function setEvent($event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return Event
     */
    public function getEvent()
    {
        return $this->event;
    }
	
	/**
     * Set authorId
     *
     * @param integer $authorId
     *
     * @return EventHour
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
     * @return EventHour
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

