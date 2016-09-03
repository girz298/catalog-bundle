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
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class UserController
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
    public function getProductsByPageAction($page){
        $onPage = (int)$page*20;
        $resp = 'products from ' . $onPage . ' to ' . ($onPage+20);
        return new Response($resp);
    }

    /**
     * @Route(
     *     "/product/{scu}",
     *     name="products_by_scu"
     * )
     * @Security("has_role('ROLE_USER')")
     * @Method({"GET"})
     */
    public function getProductsByScuAction($scu){
        return new Response('all information about product by scu: ' . $scu);
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
    public function getProductsByCategoryAction($id){
        return new Response('All products be category with id: ' . $id);
    }
}