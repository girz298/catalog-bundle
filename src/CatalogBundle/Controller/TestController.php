<?php

namespace CatalogBundle\Controller;

use CatalogBundle\Entity\Category;
use CatalogBundle\Entity\Product;
use CatalogBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class TestController extends Controller
{
    /**
     * @Route("/test_entities")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
//        $user = new User();
//        $user->setEmail('admin@mail.com');
//        $user->setIsActive(true);
//        $user->setPassword('admin');
//        $user->setUsername('admin');
//        $user->setRole('ROLE_ADMIN');
//        $em->persist($user);
//        $em->flush();



        $em = $this->getDoctrine()->getManager();


        $food = new Category();
        $food->setTitle('Food');
        $food->setStateFlag(true);

        $fruits = new Category();
        $fruits->setTitle('Fruits');
        $fruits->setParent($food);
        $fruits->setStateFlag(true);

        $vegetables = new Category();
        $vegetables->setTitle('Vegetables');
        $vegetables->setParent($food);
        $vegetables->setStateFlag(true);

        $carrots = new Category();
        $carrots->setTitle('Bags');
        $carrots->setParent($vegetables);
        $carrots->setStateFlag(true);

        $watch = new Category();
        $watch->setTitle('Watch');
        $watch->setStateFlag(true);



        $em->persist($food);
        $em->persist($fruits);
        $em->persist($vegetables);
        $em->persist($carrots);
        $em->persist($watch);
        $em->flush();


        $now = new\DateTime('now');

        $first_good = new Product();
        $first_good->setName("Rolex");
        $first_good->setStateFlag(true);
        $first_good->setCategory($watch);
        $first_good->setDescription("good watch");
        $first_good->setSku(mt_rand(1,100));
        $first_good->setCreationTime($now);
        $first_good->setLastModification($now);
        $first_good->addSimilarProduct($first_good);

        $em->persist($first_good);
        $em->flush();

        $repo = $em->getRepository('CatalogBundle:Category');

        $options = [
            'decorate' => true,
            'rootOpen' => '<ul>',
            'rootClose' => '</ul>',
            'childOpen' => '<li>',
            'childClose' => '</li>',
            'nodeDecorator' => function($node) {
                return '<a href="/category/'.$node['id'].'">'.$node['title'].'</a>';
            }
        ];
        $htmlTree = $repo->childrenHierarchy(
            null,
            false,
            $options
        );

        return $this->render('test/test.html.twig',compact('htmlTree'));
    }
}
