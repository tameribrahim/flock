<?php
/**
 * Created by amalraghav <amal.raghav@gmail.com>
 * Date: 17/04/11
 */

namespace Flock\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Flock\MainBundle\Repository\EventRepository")
 * @ORM\Table(name="events")
 * @ORM\HasLifecycleCallbacks
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length="255")
     * @Assert\MaxLength(100)
     */
    protected $name;

    /**
     * @ORM\Column(type="text", nullable="true")
     * @Assert\MaxLength(500)
     */
    protected $details;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     */
    protected $starts_at;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     */
    protected $ends_at;

    /**
     * @ORM\Column(type="string", length="255", nullable="true")
     * @Assert\Url
     * @Assert\MaxLength(255)
     */
    protected $website;

    /**
     * @ORM\Column(type="string")
     * @Assert\MaxLength(255)
     */
    protected $place;

    /**
     * @ORM\Column(type="text", nullable="true")
     * @Assert\MaxLength(500)
     */
    protected $address;

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
     * @ORM\Column(type="datetime")
     *
     */
    protected $created_at;

    /**
     * @ORM\Column(type="datetime")
     *
     */
    protected $updated_at;

    public function __construct() {
        //TODO: set the time part to the next hour or half an hour mark
        $this->setStartsAt(new \DateTime('now'));
        $this->setEndsAt(new \DateTime('+1 day'));
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
     * @Assert\True(message = "The date range is not valid!")
     * @return bool
     */
    public function isDateInRange()
    {
        if ($this->getStartsAt()->getTimestamp() > $this->getEndsAt()->getTimestamp()) {

            return false;
        }

        if ($this->getStartsAt()->getTimestamp() > strtotime('+1 year') || $this->getEndsAt()->getTimestamp() > strtotime('+1 year')) {
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
     * @return integer $id
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
     * Set details
     *
     * @param text $details
     */
    public function setDetails($details)
    {
        $this->details = $details;
    }

    /**
     * Get details
     *
     * @return text
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Set starts_at
     *
     * @param datetime $startsAt
     */
    public function setStartsAt($startsAt)
    {
        $this->starts_at = $startsAt;
    }

    /**
     * Get starts_at
     *
     * @return datetime
     */
    public function getStartsAt()
    {
        return $this->starts_at;
    }

    /**
     * Set ends_at
     *
     * @param datetime $endsAt
     */
    public function setEndsAt($endsAt)
    {
        $this->ends_at = $endsAt;
    }

    /**
     * Get ends_at
     *
     * @return datetime
     */
    public function getEndsAt()
    {
        return $this->ends_at;
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
     * Set address
     *
     * @param text $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * Get address
     *
     * @return text
     */
    public function getAddress()
    {
        return $this->address;
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
     * Set created_at
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    }

    /**
     * Get created_at
     *
     * @return datetime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;
    }

    /**
     * Get updated_at
     *
     * @return datetime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
}
