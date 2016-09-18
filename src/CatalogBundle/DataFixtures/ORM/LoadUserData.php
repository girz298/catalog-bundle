<?php
namespace CatalogBundle\DataFixtures\ORM;

use CatalogBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('user@gmail.com');
        $user->setIsActive(true);
        $user->setUsername('user');
        $user->setPassword('12345678');
        $user->setRole('ROLE_USER');

        $moderator = new User();
        $moderator->setEmail('moderator@gmail.com');
        $moderator->setIsActive(true);
        $moderator->setUsername('moderator');
        $moderator->setPassword('12345678');
        $moderator->setRole('ROLE_MODERATOR');

        $admin = new User();
        $admin->setEmail('admin@gmail.com');
        $admin->setIsActive(true);
        $admin->setUsername('admin');
        $admin->setPassword('12345678');
        $admin->setRole('ROLE_ADMIN');

        $manager->persist($user);
        $manager->persist($moderator);
        $manager->persist($admin);
        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}