<?php
/**
 * Created by PhpStorm.
 * User: doctor
 * Date: 31.08.16
 * Time: 17:45
 */

namespace CatalogBundle\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class AdminController
{
    /**
     * @param Request $request
     * @return Response
     * @Route("/admin", name="admin_page")
     */
    public function loginAction(Request $request){
        return new Response("Admin Page");
    }
}