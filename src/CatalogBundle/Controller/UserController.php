<?php
/**
 * Created by PhpStorm.
 * User: doctor
 * Date: 01.09.16
 * Time: 1:34
 */
namespace CatalogBundle\Controller;

use CatalogBundle\Entity\ForgivePassword;
use CatalogBundle\Form\User\ForgivePasswordType;
use CatalogBundle\Form\User\ResetPasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use CatalogBundle\Form\User\EditUserType;
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
     *     requirements={"id" = "[0-9]+"},
     *     name="user_remove"
     * )
     * @Method({"GET"})
     * @return Response
     */
    public function removeUser($id)
    {
        $em = $this->getDoctrine()->getManager();
        $userRepo = $em->getRepository('CatalogBundle:User');
        $user = $userRepo->findOneById($id);
        if ($user === null) {
            return new Response('0');
        } else {
            $em->remove($user);
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
//            $user = $form->getData();
            $user->setUsername($form->get('username')->getData());
            $encoder = $this->get('security.password_encoder');
            $user->setPassword($encoder->encodePassword(
                $user,
                $form->get('password')->getData()
            ));
            $user->setIsActive(true);
            $user->setRole('ROLE_USER');
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('login');

        }

        return $this->render('anon/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param $request
     * @param $id
     * @Security("has_role('ROLE_MODERATOR')")
     * @Route(
     *     "/user/{id}/edit",
     *     requirements={"id" = "[0-9]+"},
     *     name="user_edit"
     * )
     * @Method({"GET","POST"})
     * @return Response
     */
    public function editProduct(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $editable_user = $em
            ->getRepository('CatalogBundle:User')
            ->findOneById($id);
        $form = $this->createForm(EditUserType::class);
        $form->setData($editable_user->getUserDataToForm());
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em->getRepository('CatalogBundle:User')->updateDataFromForm($form, $editable_user);
            return $this->redirectToRoute('user_crud');
        }

        return $this->render('moderator/add_product.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Security("has_role('ROLE_MODERATOR')")
     * @Route(
     *     "/umail_test",
     *     name="mail_test"
     * )
     * @Method({"GET","POST"})
     * @return Response
     */
    public function testAction()
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('Hello Email')
            ->setFrom('test298298@gmail.com')
            ->setTo('girz298@gmail.com')
            ->setBody('TEST TEST TEST');
        $this->get('mailer')->send($message);

        return $this->render('anon/index.html.twig');
    }

    /**
     * @param $request
     * @Route(
     *     "/forgivepassword",
     *     name="forgive_password"
     * )
     * @Method({"GET","POST"})
     * @return Response
     */
    public function forgivePasswordAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userRepo = $em->getRepository('CatalogBundle:User');
        $form = $this->createForm(ForgivePasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $email = $form->get('email')->getData();
            $user = $userRepo->findOneByEmail($email);
            if (!is_null($user)) {
                $forgivePassword = new ForgivePassword();
                $forgivePassword->setEmail($email);
                $hash = md5(uniqid(null, true));
                $forgivePassword->setHashedKey($hash);

                $message = \Swift_Message::newInstance()
                    ->setSubject('Hello Email')
                    ->setFrom('test298298@gmail.com')
                    ->setTo($email)
                    ->setBody('To reset you password please 
                    follow this link http://localhost:8000/resetpassword/' . $hash);
                $this->get('mailer')->send($message);
                $em->persist($forgivePassword);
                $em->flush();
                $this->addFlash('notice', 'Email with instructions was send to you email!');
                return $this->redirectToRoute('login');
            } else {
                $this->addFlash('notice', 'User with that email not found!');
                return $this->redirectToRoute('forgive_password');
            }
        }
        return $this->render('anon/forgive_password.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param $request
     * @param $hash
     * @Route(
     *     "/resetpassword/{hash}",
     *     name="reset_password"
     * )
     * @Method({"GET","POST"})
     * @return Response
     */
    public function returnPasswordAction(Request $request, $hash)
    {
        $em = $this->getDoctrine()->getManager();
        $userRepo = $em->getRepository('CatalogBundle:User');
        $forgivRepo = $em->getRepository('CatalogBundle:ForgivePassword');

        $forgiver = $forgivRepo->findOneByHashedKey($hash);
        if (!is_null($forgiver)) {
            $form = $this->createForm(ResetPasswordType::class);
            $form->handleRequest($request);
            if ($form->isSubmitted()) {
                $user = $userRepo->findOneByEmail($forgiver->getEmail());
                $encoder = $this->get('security.password_encoder');
                $user->setPassword($encoder->encodePassword(
                    $user,
                    $form->get('new_password')->getData()
                ));
                $em->remove($forgiver);
                $em->persist($user);
                $em->flush();
                $this->addFlash('notice', 'You are successfully reset your password');
                return $this->redirectToRoute('login');
            }
            return $this->render('anon/forgive_password.html.twig', [
                'form' => $form->createView()
            ]);
        } else {
            return $this->redirectToRoute('index');
        }
    }
}
