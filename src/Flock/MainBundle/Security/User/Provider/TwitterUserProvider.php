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
use Symfony\Component\HttpFoundation\Session;
use \TwitterOAuth;

class TwitterUserProvider implements UserProviderInterface
{
    protected $twitter;
    protected $userManager;
    protected $validator;
    protected $session;

    public function __construct(TwitterOAuth $twitter, $userManager, $validator, Session $session)
    {
        $this->twitter = $twitter;
        $this->userManager = $userManager;
        $this->validator = $validator;
        $this->session = $session;
    }

    public function findUserByTwitterID($twitterID)
    {
        return $this->userManager->findUserBy(array('twitterID' => $twitterID));
    }

    function loadUserByUsername($username)
    {
        $user = $this->findUserByTwitterID($username);

        if (empty($user)) { //TODO: Update this everytime the user logs in
            try {
                $twitterData = $this->twitter->get('account/verify_credentials');
            } catch (\Exception $e) {
                $twitterData = null;
            }

            if (!empty($twitterData)) {
                $user = $this->userManager->createUser();
                $user->setEnabled(true);
                $user->setPassword('');
                $user->setAlgorithm('');
                $user->setTwitterData($twitterData, $this->session->get('access_token'), $this->session->get('access_token_secret'));
            }

            if (count($this->validator->validate($user, 'twitter'))) {
                // TODO: the user was found obviously, but doesnt match our expectations, do something smart
                throw new UsernameNotFoundException('The Twitter user could not be stored');
            }

            $this->userManager->updateUser($user);
        }

        if (empty($user)) {
            throw new UsernameNotFoundException('The user is not authenticated on twitter');
        }

        //TODO: Check if this is the right place for setting user culture
        $this->session->setLocale($user->getLocale());

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
