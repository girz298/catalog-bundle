<?php
/**
 * Created by PhpStorm.
 * User: doctor
 * Date: 31.08.16
 * Time: 23:50
 */

namespace CatalogBundle\Controller;

use CatalogBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render(
            '@Catalog/security/login.html.twig',
            [
                'last_username' => $lastUsername,
                'error'         => $error,
            ]
        );
    }
}