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
class ProductController
{
    /**
     * @Route(
     *     "/products/{page}",
     *     requirements={"page" = "[0-9]{1,3}"},
     *     defaults={"page" = 1},
     *     name="products_by_page"
     * )
     * @Security
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
     * @Method({"GET"})
     */
    public function getProductsByScuAction($scu){
        return new Response('all information about product by scu: ' . $scu);
    }
}