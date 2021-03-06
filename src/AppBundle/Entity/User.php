<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
	
	/**
     * @ORM\OneToMany(targetEntity="Event", mappedBy="author")
     */
    private $events;
	
	/**
     * @ORM\OneToMany(targetEntity="EventHour", mappedBy="author")
	 * @ORM\OrderBy({"day" = "ASC", "start" = "ASC", "end" = "ASC"})
     */
    private $eventHours;
	
	/**
     * @ORM\OneToMany(targetEntity="EventHour", mappedBy="trainer")
	 * @ORM\OrderBy({"day" = "ASC", "start" = "ASC", "end" = "ASC"})
     */
    private $trainerEventHours;
	
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
     * @ORM\Column(name="username", type="string", length=25, unique=true)
     */
    private $username;
	
	/**
     * @var string
     *
     * @ORM\Column(name="display_name", type="string", length=25)
     */
    private $displayName;
	
	/**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPassword;
	
    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=64)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=60, unique=true)
     */
    private $email;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;
	
	/**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=255, unique=false)
     */
    private $role;
	
	public function __construct()
	{
		$this->events = new ArrayCollection();
		$this->eventHours = new ArrayCollection();
		
		$this->setRole('ROLE_USER')
			->setActive(true);
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
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }
	
	/**
     * Set displayName
     *
     * @param string $displayName
     *
     * @return User
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;

        return $this;
    }

    /**
     * Get displayName
     *
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

	/**
     * Get planPassword
     *
     * @return string
     */
	public function getPlainPassword()
    {
        return $this->plainPassword;
    }
	
	/**
     * Set planPassword
     *
     * @return string
     */
    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }
	
    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return User
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }
	
	/**
     * Set role
     *
     * @param string $role
     *
     * @return User
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }
	
	/**
     * Set evens
     *
     * @param ArrayCollection $events
     *
     * @return Event
     */
    public function setEvents($events)
    {
        $this->events = $events;

        return $this;
    }
	
	/**
     * Get events
     *
     * @return ArrayCollection
     */
    public function getEvents()
    {
        return $this->events;
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
     * Set trainerEventHours
     *
     * @param ArrayCollection $trainerEventHours
     *
     * @return Event
     */
    public function setTrainerEventHours($trainerEventHours)
    {
        $this->trainerEventHours = $trainerEventHours;

        return $this;
    }

    /**
     * Get trainerEventHours
     *
     * @return ArrayCollection
     */
    public function getTrainerEventHours()
    {
        return $this->trainerEventHours;
    }
	
	public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }
	
	public function getRoles()
    {
        return explode(',', $this->getRole());
    }

    public function eraseCredentials()
    {
    }
	
	/** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized);
    }
}

