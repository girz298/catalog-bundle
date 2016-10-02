<?php
/**
 * Created by PhpStorm.
 * User: doctor
 * Date: 01.09.16
 * Time: 1:34
 */
namespace CatalogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use CatalogBundle\Form\User\UserType;
use CatalogBundle\Entity\User;

class UserController extends Controller
{

    /**
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/user/crud", name="user_crud")
     * @Method({"GET"})
     */
    public function gridProducts()
    {
        return $this->render('moderator/user_crud.html.twig');
    }



    /**
     * @param Get
     * @Security("has_role('ROLE_MODERATOR')")
     * @Route(
     *     "/user/{id}/remove",
     *     requirements={"id" = "[0-9]{1,3}"},
     *     name="user_remove"
     * )
     * @Method({"GET"})
     * @return Response
     */
    public function removeProduct($id)
    {
        $em = $this->getDoctrine()->getManager();
        $prodRepo = $em->getRepository('CatalogBundle:User');
        $product = $prodRepo->findOneById($id);
        if ($product === null) {
            return new Response('0');
        } else {
            $em->remove($product);
            $em->flush();
            return new Response('1');
        }
    }


    /**
     * @Route("/", name="index")
     * @Method({"GET"})
     * @return Response
     */
    public function indexAction()
    {
        $tokenStorage = $this->get('security.token_storage');
        if ($tokenStorage->getToken()->isAuthenticated()) {
            return $this->redirectToRoute('products_by_category', ['id' => '39']);
        }
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
     * @param Request $request
     * @Route("/register", name="register")
     * @Method({"GET","POST"})
     * @return Response
     */
    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $em = $this->getDoctrine()->getManager();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('login');

        }

        return $this->render('anon/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}