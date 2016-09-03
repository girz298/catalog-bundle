<?php
/**
 * Created by PhpStorm.
 * User: doctor
 * Date: 03.09.16
 * Time: 15:08
 */

namespace CatalogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class ModeratorContoller extends Controller
{
    /**
     * @Security("has_role('ROLE_MODERATOR')")
     * @Route("/product/{scu}/edit")
     * @Method({"GET"})
     */
    public function editProduct($scu){
        return new Response("Page edit product granted to ROLE_MODERATOR");
    }

    /**
     * @Security("has_role('ROLE_MODERATOR')")
     * @Route("/category/{id}/edit")
     * @Method({"GET"})
     */
    public function editCategory($id){
        return new Response("Page edit product granted to ROLE_MODERATOR");
    }
}