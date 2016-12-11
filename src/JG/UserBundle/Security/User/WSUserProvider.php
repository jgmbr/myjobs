<?php
/**
 * Created by PhpStorm.
 * User: Justine GAMBIER
 * Date: 11/12/2016
 * Time: 14:48
 */

// src/JG/UserBundle/Security/User/WSUserProvider.php
namespace JG\UserBundle\Security\User;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

class WSUserProvider implements UserProviderInterface
{
    protected $user;

    public function __contsruct (UserInterface $user) {
        $this->user = $user;
    }

    public function loadUserByUsername($username)
    {
        /*// make a call to your webservice here
        $userData = $this->get('app.ws_user_provider');
        // pretend it returns an array on success, false if there is no user

        if ($userData) {

            $password = '123456';

            $salt = '';

            $roles = array('ROLE_USER');

            // ...

            return new WSUser($username, $password, $salt, $roles);
        }*/

        $user = User::find(array('username'=>$username));

        if (empty($user)) {
            throw new UsernameNotFoundException(
                sprintf('Username "%s" does not exist.', $username)
            );
        }

        $this->user = $user;

        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof WSUser) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return $class === 'JG\UserBundle\Security\User\WSUser';
    }
}