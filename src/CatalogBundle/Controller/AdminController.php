<?php
/**
 * Created by PhpStorm.
 * User: doctor
 * Date: 31.08.16
 * Time: 17:45
 */

namespace CatalogBundle\Controller;


use CatalogBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     * @Route("/admin", name="admin_page")
     */
    public function loginAction(Request $request){
        return $this->render("@Catalog/admin/admin.html.twig",[
            'username' => $this->get('security.token_storage')->getToken()->getUsername(),
        ]);
    }
}