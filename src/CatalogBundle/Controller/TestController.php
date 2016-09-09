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

        $repo = $em->getRepository('CatalogBundle:Category');

        $watch = $repo->findOneByTitle('test5');

//        $food = new Category();
//        $food->setTitle('test455');
//        $food->setStateFlag(true);
//        $food->setParent($watch);
//
//        $em->persist($watch);
//        $em->persist($food);
//        $em->flush();

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
                return '<a href="/category/' . $node['id'] . '">' . $node['title'] . '</a>';
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
