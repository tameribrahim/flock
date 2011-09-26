<?php

namespace Flock\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Flock\MainBundle\Entity\Activity
 *
 * @ORM\Table(name="activities")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="Flock\MainBundle\Respository\ActivityRepository")
 */
class Activity
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="activity_type", type="integer")
     */
    protected $activityType;

    /**
     * @ORM\ManyToOne(targetEntity="Flock\MainBundle\Entity\User", inversedBy="activity")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Flock\MainBundle\Entity\Flock", inversedBy="activity")
     * @ORM\JoinColumn(name="flock_id", referencedColumnName="id")
     */
    protected $flock;

    /**
     * @ORM\Column(name="username", type="string", length="255")
     */
    protected $username;

    /**
     * @ORM\Column(name="flock_name", type="string", length="255")
     */
    protected $flockName;

    /**
     * @ORM\Column(name="starts_at", type="datetime")
     */
    protected $startsAt;

    /**
     * @ORM\Column(name="ends_at", type="datetime")
     */
    protected $endsAt;

    /**
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @ORM\Column(name="updated_at", type="datetime")
     */
    protected $updatedAt;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function __toString()
    {
        //TODO: convert the activity into human readable string
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
     * Set activityType
     *
     * @param integer $activityType
     */
    public function setActivityType($activityType)
    {
        $this->activityType = $activityType;
    }

    /**
     * Get activityType
     *
     * @return integer
     */
    public function getActivityType()
    {
        return $this->activityType;
    }

    /**
     * Set username
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
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
     * Set flockName
     *
     * @param string $flockName
     */
    public function setFlockName($flockName)
    {
        $this->flockName = $flockName;
    }

    /**
     * Get flockName
     *
     * @return string
     */
    public function getFlockName()
    {
        return $this->flockName;
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
     * @return datetime
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
     * @return datetime
     */
    public function getEndsAt()
    {
        return $this->endsAt;
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
     * Set flock
     *
     * @param Flock\MainBundle\Entity\Flock $flock
     */
    public function setFlock(\Flock\MainBundle\Entity\Flock $flock)
    {
        $this->flock = $flock;
    }

    /**
     * Get flock
     *
     * @return Flock\MainBundle\Entity\Flock
     */
    public function getFlock()
    {
        return $this->flock;
    }
}
