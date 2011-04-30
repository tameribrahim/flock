<?php
/**
 * Created by amalraghav <amal.raghav@gmail.com>
 * Date: 17/04/11
 */

namespace Flock\MainBundle\Entity;

/**
 * @orm:Entity
 * @orm:Table(name="events")
 * @orm:HasLifecycleCallbacks
 */
class Event
{
    /**
     * @orm:Id
     * @orm:Column(type="integer")
     * @orm:GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @orm:Column(type="string", length="255")
     * @assert:MaxLength(100)
     */
    protected $event_name;

    /**
     * @orm:Column(type="text", nullable="true")
     * @assert:MaxLength(500)
     */
    protected $event_details;

    /**
     * @orm:Column(type="datetime")
     * @assert:NotBlank
     */
    protected $event_start;

    /**
     * @orm:Column(type="datetime")
     * @assert:NotBlank
     */
    protected $event_end;

    /**
     * @orm:Column(type="string", length="255", nullable="true")
     * @assert:Url
     * @assert:MaxLength(255)
     */
    protected $website;

    /**
     * @orm:Column(type="string")
     * @assert:MaxLength(255)
     */
    protected $place;

    /**
     * @orm:Column(type="text", nullable="true")
     * @assert:MaxLength(500)
     */
    protected $address;

    /**
     * @orm:Column(type="decimal", precision="9", scale="6")
     * @assert:NotBlank
     */
    protected $lat;

    /**
     * @orm:Column(type="decimal", precision="9", scale="6")
     * @assert:NotBlank
     */
    protected $lng;

//    /**
//     * @orm:Column(type="smallint")
//     * @assert:NotBlank
//     */
//    protected $zoom;

    /**
     * @orm:Column(type="datetime")
     *
     */
    protected $created_at;

    /**
     * @orm:Column(type="datetime")
     *
     */
    protected $updated_at;

    /**
     * @orm:prePersist
     */
    public function onPrePersist()
    {
        $this->setCreatedAt(new \DateTime("now"));
        $this->setUpdatedAt(new \DateTime("now"));
    }

    /**
     * @orm:preUpdate
     */
    public function onPreUpdate()
    {
        $this->setUpdatedAt(new \DateTime("now"));
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
     * Set event_name
     *
     * @param string $eventName
     */
    public function setEventName($eventName)
    {
        $this->event_name = $eventName;
    }

    /**
     * Get event_name
     *
     * @return string $eventName
     */
    public function getEventName()
    {
        return $this->event_name;
    }

    /**
     * Set event_details
     *
     * @param text $eventDetails
     */
    public function setEventDetails($eventDetails)
    {
        $this->event_details = $eventDetails;
    }

    /**
     * Get event_details
     *
     * @return text $eventDetails
     */
    public function getEventDetails()
    {
        return $this->event_details;
    }

    /**
     * Set event_start
     *
     * @param datetime $eventStart
     */
    public function setEventStart($eventStart)
    {
        $this->event_start = $eventStart;
    }

    /**
     * Get event_start
     *
     * @return datetime $eventStart
     */
    public function getEventStart()
    {
        return $this->event_start;
    }

    /**
     * Set event_end
     *
     * @param datetime $eventEnd
     */
    public function setEventEnd($eventEnd)
    {
        $this->event_end = $eventEnd;
    }

    /**
     * Get event_end
     *
     * @return datetime $eventEnd
     */
    public function getEventEnd()
    {
        return $this->event_end;
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
     * @return string $website
     */
    public function getWebsite()
    {
        return $this->website;
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
     * @return datetime $createdAt
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
     * @return datetime $updatedAt
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
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
     * @return text $address
     */
    public function getAddress()
    {
        return $this->address;
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
     * @return string $place
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
     * @return decimal $lat
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
     * @return decimal $lng
     */
    public function getLng()
    {
        return $this->lng;
    }
}
