<?php
namespace CatalogBundle\DataFixtures\ORM;

use CatalogBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData extends AbstractFixture implements
    OrderedFixtureInterface,
    ContainerAwareInterface
{
    private $container;
    public function load(ObjectManager $manager)
    {

        $encoder = $this->container->get('security.password_encoder');

        $user = new User();
        $user->setEmail('user@gmail.com');
        $user->setIsActive(true);
        $user->setUsername('user');
        $user->setPassword($encoder->encodePassword(
            $user,
            '12345678'
        ));
        $user->setRole('ROLE_USER');

        $moderator = new User();
        $moderator->setEmail('moderator@gmail.com');
        $moderator->setIsActive(true);
        $moderator->setUsername('moderator');
        $moderator->setPassword($encoder->encodePassword(
            $moderator,
            '12345678'
        ));
        $moderator->setRole('ROLE_MODERATOR');

        $admin = new User();
        $admin->setEmail('admin@gmail.com');
        $admin->setIsActive(true);
        $admin->setUsername('admin');
        $admin->setPassword($encoder->encodePassword(
            $admin,
            '12345678'
        ));
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

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}