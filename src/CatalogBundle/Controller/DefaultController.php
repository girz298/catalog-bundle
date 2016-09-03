<?php

namespace CatalogBundle\Controller;

use CatalogBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/new_user")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = new User();
        $user->setEmail('test@mail.com');
        $user->setIsActive(true);
        $user->setPassword('tast');
        $user->setUsername('test');
        $user->setRole('ROLE_USER');
        $em->persist($user);
        $em->flush();

        return new Response("user creted");
    }
}
