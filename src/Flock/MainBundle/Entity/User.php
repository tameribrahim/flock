<?php
/**
 * Created by amalraghav <amal.raghav@gmail.com>
 * Date: 29/08/11
 */

namespace Flock\MainBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @ORM\Entity(repositoryClass="Flock\MainBundle\Repository\UserRepository")
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
     * @ORM\Column(name="oauth_token", type="string")
     * @Assert\NotBlank(groups={"twitter"})
     */
    protected $oauthToken;

    /**
     * @ORM\Column(name="oauth_secret", type="string")
     * @Assert\NotBlank(groups={"twitter"})
     */
    protected $oauthSecret;

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

    /**
     * @ORM\Column(name="locale", type="string", length=5)
     * @Assert\NotBlank(groups={"twitter"})
     */
    protected $locale;

    /**
     * @ORM\OneToMany(targetEntity="Flock", mappedBy="user")
     */
    protected $flocksCreated;

    /**
     * @ORM\OneToMany(targetEntity="Attendee", mappedBy="user")
     */
    protected $flocksAttending;

    /**
     * @ORM\OneToMany(targetEntity="Activity", mappedBy="user")
     */
    protected $activity;

    public function __construct()
    {
        parent::__construct();

        $this->flocksCreated = new ArrayCollection();
        $this->flocksAttending = new ArrayCollection();
        $this->activity = new ArrayCollection();
        $this->userCulture = 'en';
    }

    public function setTwitterData($twitterData, $oauth_token, $oauth_secret)
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
        if (isset($twitterData->lang)) {
            $this->setLocale($twitterData->lang);
        }
        //set access token
        $this->setOauthToken($oauth_token);
        $this->setOauthSecret($oauth_secret);
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
     * @param string $size
     * @return mixed
     */
    public function getProfileImageUrl($size = 'normal')
    {
        if ($size != 'normal') {
            return str_replace('_normal','_'.$size,$this->profileImageUrl);
        }
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

    /**
     * Set oauthToken
     *
     * @param string $oauthToken
     */
    public function setOauthToken($oauthToken)
    {
        $this->oauthToken = $oauthToken;
    }

    /**
     * Get oauthToken
     *
     * @return string
     */
    public function getOauthToken()
    {
        return $this->oauthToken;
    }

    /**
     * Set oauthSecret
     *
     * @param string $oauthSecret
     */
    public function setOauthSecret($oauthSecret)
    {
        $this->oauthSecret = $oauthSecret;
    }

    /**
     * Get oauthSecret
     *
     * @return string
     */
    public function getOauthSecret()
    {
        return $this->oauthSecret;
    }

    /**
     * Add flocksCreated
     *
     * @param Flock\MainBundle\Entity\Flock $flocksCreated
     */
    public function addFlocksCreated(\Flock\MainBundle\Entity\Flock $flocksCreated)
    {
        $this->flocksCreated[] = $flocksCreated;
    }

    /**
     * Get flocksCreated
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getFlocksCreated()
    {
        return $this->flocksCreated;
    }

    /**
     * Set locale
     *
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * Get locale
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Add flocksAttending
     *
     * @param Flock\MainBundle\Entity\Attendee $flocksAttending
     */
    public function addFlocksAttending(\Flock\MainBundle\Entity\Attendee $flocksAttending)
    {
        $this->flocksAttending[] = $flocksAttending;
    }

    /**
     * Get flocksAttending
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getFlocksAttending()
    {
        return $this->flocksAttending;
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