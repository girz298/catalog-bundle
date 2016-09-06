<?php
/**
 * Created by PhpStorm.
 * User: doctor
 * Date: 03.09.16
 * Time: 15:02
 */

namespace CatalogBundle\Controller;

use CatalogBundle\Entity\User;
use CatalogBundle\Form\BasicUserType;
use CatalogBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class GuestController  extends Controller
{
    /**
     * @Route("/", name="index")
     * @Method({"GET"})
     * @return Response
     */
    public function indexAction()
    {
        return $this->render('anon/index.html.twig');
    }

    /**
     * @param Post
     * @Route("/login", name="login")
     * @Method({"POST","GET"})
     * @return Response
     */
    public function loginAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render(
            'security/login.html.twig',
            [
                'last_username' => $lastUsername,
                'error'         => $error,
            ]
        );
    }

    /**
     * @param Post
     * @Route("/register", name="register")
     * @Method({"GET","POST"})
     * @return Response
     */
    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class,$user);
        $em = $this->getDoctrine()->getManager();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('login');

        }

        return $this->render('anon/register.html.twig',[
            'form' => $form->createView(),
        ]);
    }
}