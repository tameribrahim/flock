<?php
/**
 * Created by Amal Raghav <amal.raghav@gmail.com>
 * Date: 12/09/11
 */

namespace Flock\MainBundle\Security\User\Provider;

use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use \TwitterOAuth;
use FOS\UserBundle\Entity\UserManager;
use Symfony\Component\Validator\Validator;

class TwitterProvider implements UserProviderInterface
{
    protected $twitter;
    protected $userManager;
    protected $validator;

    public function __construct(TwitterOAuth $twitter, UserManager $userManager, Validator $validator)
    {
        $this->twitter = $twitter;
        $this->userManager = $userManager;
        $this->validator = $validator;
    }

    public function findUserByTwitterID($twitterID)
    {
        return $this->userManager->findUserBy(array('twitterID' => $twitterID));
    }

    function loadUserByUsername($username)
    {
        $user = $this->findUserByTwitterID($username);

        try {
            $twitterData = $this->twitter->get('account/verify_credentials');
        } catch (\Exception $e) {
            $twitterData = null;
        }

        if (!empty($twitterData)) {
            if (empty($user)) {
                $user = $this->userManager->createUser();
                $user->setEnabled(true);
                $user->setPassword('');
                $user->setAlgorithm('');
            }

            $user->setTwitterData($twitterData);

            if (count($this->validator->validate($user, 'twitter'))) {
                // TODO: the user was found obviously, but doesnt match our expectations, do something smart
                throw new UsernameNotFoundException('The Twitter user could not be stored');
            }
            $this->userManager->updateUser($user);
        }

        if (empty($user)) {
            throw new UsernameNotFoundException('The user is not authenticated on facebook');
        }

        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$this->supportsClass(get_class($user)) || !$user->getTwitterID()) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->loadUserByUsername($user->getTwitterID());
    }

    public function supportsClass($class)
    {
        return $this->userManager->supportsClass($class);
    }
}
