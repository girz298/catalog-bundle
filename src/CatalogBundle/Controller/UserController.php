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
use CatalogBundle\Entity\Product;

/**
 * Class UserController
 * @package CatalogBundle\Controller
 */
class UserController extends Controller
{
    /**
     * @Route(
     *     "/products/{page}",
     *     requirements={"page" = "[0-9]{1,3}"},
     *     defaults={"page" = 1},
     *     name="products_by_page"
     * )
     * @Security("has_role('ROLE_USER')")
     * @Method({"GET"})
     */
    public function getProductsByPageAction($page)
    {
        $onPage = (int)$page*20;
        $resp = 'products from ' . $onPage . ' to ' . ($onPage+20);
        return new Response($resp);
    }

    /**
     * @Route(
     *     "/product/{id}",
     *     name="products_by_scu"
     * )
     * @Security("has_role('ROLE_USER')")
     * @Method({"GET"})
     */
    public function getProductsByScuAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('CatalogBundle:Product');
        $product = $repo->findOneById($id);
        $htmlTree = $this->get('app.category_menu_generator')->getMenu();
        return $this->render('test/test.html.twig', compact('htmlTree', 'product'));
    }

    /**
     * @Route(
     *     "/category/{id}",
     *     requirements={"id" = "[0-9]{1,3}"},
     *     defaults={"page" = 1},
     *     name="products_by_category"
     * )
     * @Security("has_role('ROLE_USER')")
     * @Method({"GET"})
     */
    public function getProductsByCategoryAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
//        $query = $em
//            ->createQuery("SELECT a FROM CatalogBundle:Product a");
        $query = $em
            ->createQueryBuilder()
            ->select('p')
            ->from('CatalogBundle:Product', 'p')
            ->where('p.category=' . $id)
            ->getQuery();

        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            8
        );

        $htmlTree = $this->get('app.category_menu_generator')->getMenu();
        return $this->render('test/test.html.twig', compact('htmlTree', 'id', 'pagination'));
    }
}