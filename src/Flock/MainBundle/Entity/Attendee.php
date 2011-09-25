<?php
/**
 * Created by Amal Raghav <amal.raghav@gmail.com>
 * Date: 23/09/11
 */

namespace Flock\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Flock\MainBundle\Repository\AttendeeRepository")
 * @ORM\Table(name="attendees")
 * @ORM\HasLifecycleCallbacks
 */
class Attendee
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Flock\MainBundle\Entity\Flock", inversedBy="attendees")
     * @ORM\JoinColumn(name="flock_id", referencedColumnName="id")
     */
    protected $flock;

    /**
     * @ORM\ManyToOne(targetEntity="Flock\MainBundle\Entity\User", inversedBy="flocksAttending")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @ORM\Column(name="updated_at", type="datetime")
     */
    protected $updatedAt;

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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
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
}