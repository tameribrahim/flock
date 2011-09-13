<?php
/**
 * Created by amalraghav <amal.raghav@gmail.com>
 * Date: 29/08/11
 */

namespace Flock\MainBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(groups={"twitter"})
     */
    protected $name;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(groups={"twitter"})
     */
    protected $twitterID;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(groups={"twitter"})
     */
    protected $screenName;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(groups={"twitter"})
     */
    protected $profileImageUrl;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    public function setTwitterData($twitterData)
    {
        $this->screenName = $twitterData['screen_name'];
        $this->twitterID = $twitterData['id'];
        $this->name = $twitterData['name'];
        $this->profileImageUrl = $twitterData['profile_image_url'];
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
     * Set screenName
     *
     * @param string $screenName
     */
    public function setScreenName($screenName)
    {
        $this->screenName = $screenName;
    }

    /**
     * Get screenName
     *
     * @return string
     */
    public function getScreenName()
    {
        return $this->screenName;
    }

    /**
     * Set profileImageUrl
     *
     * @param string $profileImageUrl
     */
    public function setProfileImageUrl($profileImageUrl)
    {
        $this->profileImageUrl = $profileImageUrl;
    }

    /**
     * Get profileImageUrl
     *
     * @return string
     */
    public function getProfileImageUrl()
    {
        return $this->profileImageUrl;
    }

    /**
     * Set twitterID
     *
     * @param integer $twitterID
     */
    public function setTwitterID($twitterID)
    {
        $this->twitterID = $twitterID;
    }

    /**
     * Get twitterID
     *
     * @return integer 
     */
    public function getTwitterID()
    {
        return $this->twitterID;
    }
}