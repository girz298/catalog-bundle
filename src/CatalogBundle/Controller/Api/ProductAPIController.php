<?php
namespace CatalogBundle\Controller\Api;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ProductAPIController extends Controller
{
    /**
     * @Route(
     *     "/api/products/{per_page}/{page}",
     *     requirements={
     *          "page" = "[0-9]{1,3}",
     *          "per_page" = "[0-9]{1,3}"
     *     },
     *     defaults={
     *          "page" = 1
     *          "per_page" = 20
     *     },
     *     name = "api_per_page"
     *     )
     */
    public function getProductsByPageAction($per_page, $page)
    {
        $em = $this->getDoctrine()->getManager();
        return new Response($per_page . '           ' . $page);
    }
}