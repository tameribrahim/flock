<?php
/**
 * Created by amalraghav <amal.raghav@gmail.com>
 * Date: 17/04/11
 */

namespace Flock\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Flock\MainBundle\Repository\FlockRepository")
 * @ORM\Table(name="flocks")
 * @ORM\HasLifecycleCallbacks
 */
class Flock
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Flock\MainBundle\Entity\User", inversedBy="flocksCreated")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\Column(type="string", length="255")
     * @Assert\MaxLength(255)
     */
    protected $name;

    /**
     * @ORM\Column(name="starts_at",type="datetime")
     * @Assert\NotBlank
     */
    protected $startsAt;

    /**
     * @ORM\Column(name="ends_at", type="datetime", nullable="true")
     */
    protected $endsAt;

    /**
     * @ORM\Column(type="string", length="255")
     * @Assert\MaxLength(255)
     */
    protected $place;

    /**
     * @ORM\Column(type="decimal", precision="9", scale="6")
     */
    protected $lat;

    /**
     * @ORM\Column(type="decimal", precision="9", scale="6")
     */
    protected $lng;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $zoom;

    /**
     * @ORM\Column(type="string", nullable="true");
     */
    protected $hashTag;

    /**
     * @ORM\Column(type="string", length="255", nullable="true")
     * @Assert\Url(message="Please enter a valid URL")
     * @Assert\MaxLength(255)
     */
    protected $website;

    /**
     * @ORM\Column(name="created_at", type="datetime")
     *
     */
    protected $createdAt;

    /**
     * @ORM\Column(name="updated_at", type="datetime")
     *
     */
    protected $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="Attendee", mappedBy="flock")
     */
    protected $attendees;

    /**
     * @ORM\OneToMany(targetEntity="Activity", mappedBy="flock")
     */
    protected $activity;

    public function __construct() {
        $date = new \DateTime('+1 hours');
        $date->setTime(date('H', $date->getTimestamp()), 0, 0);
        $this->setStartsAt($date);

        $this->attendees = new \Doctrine\Common\Collections\ArrayCollection();
        $this->activity = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return (string)$this->getId();
    }

    /**
     * @ORM\prePersist
     */
    public function onPrePersist()
    {
        $this->setCreatedAt(new \DateTime("now"));
        $this->setUpdatedAt(new \DateTime("now"));
    }

    /**
     * @ORM\preUpdate
     */
    public function onPreUpdate()
    {
        $this->setUpdatedAt(new \DateTime("now"));
    }

    /**
     * @Assert\True(message = "The date range is invalid!")
     * @return bool
     */
    public function isDateInRange()
    {
        //Error:Check if the starts_at is less than the least possible day
        $leastPossibleDate = new \DateTime("now", new \DateTimeZone('Pacific/Honolulu'));
        if ($this->getStartsAt()->getTimestamp() < ($leastPossibleDate->getTimestamp() + $leastPossibleDate->getOffset() - $this->getStartsAt()->getOffset())) {
            return false;
        }

        if (!$this->getEndsAt()) {
            return true;
        }

        if ($this->getStartsAt()->getTimestamp() > $this->getEndsAt()->getTimestamp()) {
            return false;
        }

        return true;
    }

    /**
     * @Assert\True(message = "The start date should be inside next one year!")
     * @return bool
     */
    public function isStartDateInsideOneYear()
    {
        $highestPossibleDate = new \DateTime("+1 year");
        $dateTimeZone = new \DateTimeZone('Pacific/Honolulu');
        $highestPossibleDate->setTimezone($dateTimeZone);

        if ($this->getStartsAt()->getTimestamp() > $highestPossibleDate->getTimestamp()) {
            return false;
        }

        return true;
    }

    /**
     * @Assert\True(message = "The end date seems to be unreal!")
     * @return bool
     */
    public function isEndDateTooLong()
    {
        if (!$this->getEndsAt()) {
            return true;
        }

        $highestPossibleDate = new \DateTime("+2 year");
        $dateTimeZone = new \DateTimeZone('Pacific/Honolulu');
        $highestPossibleDate->setTimezone($dateTimeZone);

        if ($this->getEndsAt()->getTimestamp() > $highestPossibleDate->getTimestamp()) {
            return false;
        }

        return true;
    }

    /**
     * @Assert\True(message = "The map location is not valid!")
     */
    public function isValidMapData()
    {
        if (!$this->lat || !$this->lng || !$this->zoom) {

            return false;
        }

        return true;
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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set startsAt
     *
     * @param datetime $startsAt
     */
    public function setStartsAt($startsAt)
    {
        $this->startsAt = $startsAt;
    }

    /**
     * Get startsAt
     *
     * @return \DateTime
     */
    public function getStartsAt()
    {
        return $this->startsAt;
    }

    /**
     * Set endsAt
     *
     * @param datetime $endsAt
     */
    public function setEndsAt($endsAt)
    {
        $this->endsAt = $endsAt;
    }

    /**
     * Get endsAt
     *
     * @return \DateTime
     */
    public function getEndsAt()
    {
        return $this->endsAt;
    }

    /**
     * Set place
     *
     * @param string $place
     */
    public function setPlace($place)
    {
        $this->place = $place;
    }

    /**
     * Get place
     *
     * @return string
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Set lat
     *
     * @param decimal $lat
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    }

    /**
     * Get lat
     *
     * @return decimal
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set lng
     *
     * @param decimal $lng
     */
    public function setLng($lng)
    {
        $this->lng = $lng;
    }

    /**
     * Get lng
     *
     * @return decimal
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * Set zoom
     *
     * @param smallint $zoom
     */
    public function setZoom($zoom)
    {
        $this->zoom = $zoom;
    }

    /**
     * Get zoom
     *
     * @return smallint
     */
    public function getZoom()
    {
        return $this->zoom;
    }

    /**
     * Set hashTag
     *
     * @param string $hashTag
     */
    public function setHashTag($hashTag)
    {
        if (0 !== strpos($hashTag,'#')) {
            $hashTag = "#".$hashTag;
        }
        $this->hashTag = $hashTag;
    }

    /**
     * Get hashTag
     *
     * @return string
     */
    public function getHashTag()
    {
        return $this->hashTag;
    }

    /**
     * Set website
     *
     * @param string $website
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    }

    /**
     * Get website
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set createdAt
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get createdAt
     *
     * @return datetime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Get updatedAt
     *
     * @return datetime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set user
     *
     * @param Flock\MainBundle\Entity\User $user
     */
    public function setUser(\Flock\MainBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return Flock\MainBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add attendees
     *
     * @param Flock\MainBundle\Entity\Attendee $attendees
     */
    public function addAttendees(\Flock\MainBundle\Entity\Attendee $attendees)
    {
        $this->attendees[] = $attendees;
    }

    /**
     * Get attendees
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getAttendees()
    {
        return $this->attendees;
    }

    /**
     * Add activity
     *
     * @param Flock\MainBundle\Entity\Activity $activity
     */
    public function addActivity(\Flock\MainBundle\Entity\Activity $activity)
    {
        $this->activity[] = $activity;
    }

    /**
     * Get activity
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getActivity()
    {
        return $this->activity;
    }
}