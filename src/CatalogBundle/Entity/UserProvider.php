<?php
/**
 * Created by PhpStorm.
 * User: doctor
 * Date: 30.08.16
 * Time: 18:04
 */

namespace CatalogBundle\Entity;


use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;


class UserProvider implements UserProviderInterface
{
    private $users = [
        'admin' => [
            'username' => 'admin',
            'password' => '12345678',
            'roles' => ['ROLE_ADMIN']
        ],
        'test' => [
            'username' => 'test',
            'password' => '12345678',
            'roles' => ['ROLE_USER']
        ],
    ];

    public function loadUserByUsername($username)
    {
        if (!array_key_exists($username,$this->users)) {
            throw  new UsernameNotFoundException(
              sprintf('Username "%s" does not exist' . $username)
            );
        }

        $user = $this->users[$username];

        return new User(
            $user['username'],
            $user['password'],
            $user['username'],
            $user['roles']
            );
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return $class === 'UserProvider\Entity\UserProvider';
    }
}

