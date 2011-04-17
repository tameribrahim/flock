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
     * @assert:MaxLength(255)
     */
    protected $event_name;

    /**
     * @orm:Column(type="text", nullable=true)
     * @assert:MaxLength(1000)
     */
    protected $event_details;

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
}
