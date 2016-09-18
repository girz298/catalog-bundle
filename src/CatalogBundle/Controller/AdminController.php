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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AdminController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     * @Route("/admin", name="admin_page")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function adminAction(Request $request)
    {
        return $this->render("admin/admin.html.twig", [
            'username' => $this->get('security.token_storage')->getToken()->getUsername(),
        ]);
    }
}