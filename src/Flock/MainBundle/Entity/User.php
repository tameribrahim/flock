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
class User extends BaseUser implements \Serializable
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
     * @ORM\Column(name="twitter_id", type="integer")
     * @Assert\NotBlank(groups={"twitter"})
     */
    protected $twitterID;

    /**
     * @ORM\Column(name="screen_name", type="string")
     * @Assert\NotBlank(groups={"twitter"})
     */
    protected $screenName;

    /**
     * @ORM\Column(name="profile_image_url", type="string")
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
        if (isset($twitterData->id)) {
            var_dump($twitterData->id);
            $this->setTwitterID($twitterData->id);
            $this->setEmail($twitterData->id.'@'.'twitter.com');
            $this->addRole('ROLE_TWITTER');
        }
        if (isset($twitterData->screen_name)) {
            $this->setScreenName($twitterData->screen_name);
        }
        if (isset($twitterData->name)) {
            $this->setName($twitterData->name);
        }
        if (isset($twitterData->profile_image_url)) {
            $this->setProfileImageUrl($twitterData->profile_image_url);
        }
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
        $this->setUsername($twitterID);
        $this->salt = '';
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

    /**
     * Serializes the user.
     *
     * The serialized data have to contain the fields used by the equals method and the username.
     *
     * @return string
     */
    public function serialize()
    {
        return serialize(array(
            $this->password,
            $this->salt,
            $this->usernameCanonical,
            $this->username,
            $this->expired,
            $this->locked,
            $this->credentialsExpired,
            $this->enabled,
            $this->twitterID
        ));
    }

    /**
     * Unserializes the user.
     *
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        list(
            $this->password,
            $this->salt,
            $this->usernameCanonical,
            $this->username,
            $this->expired,
            $this->locked,
            $this->credentialsExpired,
            $this->enabled,
            $this->twitterID
        ) = unserialize($serialized);
    }
}
