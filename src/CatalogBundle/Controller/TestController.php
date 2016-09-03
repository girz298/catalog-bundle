<?php

namespace CatalogBundle\Controller;

use CatalogBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class TestController extends Controller
{
    /**
     * @Route("/new_user")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = new User();
        $user->setEmail('admin@mail.com');
        $user->setIsActive(true);
        $user->setPassword('admin');
        $user->setUsername('admin');
        $user->setRole('ROLE_ADMIN');
        $em->persist($user);
        $em->flush();

        return new Response('User: ' . $user->getUsername()  . ' was creted!');
    }
}
