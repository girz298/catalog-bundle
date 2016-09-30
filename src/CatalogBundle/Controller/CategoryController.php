<?php
namespace CatalogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    /**
     * @param $request
     * @param $id
     * @Route(
     *     "/category/{id}",
     *     requirements={"id" = "[0-9]{1,3}"},
     *     name="products_by_category"
     * )
     * @Security("has_role('ROLE_USER')")
     * @Method({"GET"})
     * @return Response
     */
    public function getProductsByCategoryAction(Request $request, $id)
    {
        $paginator = $this->get('knp_paginator');

        $pagination = $this
            ->get('app.category_paginator_generator')
            ->getPaginator($request, $paginator, $id);

        $htmlTree = $this->get('app.category_menu_generator')->getMenu();
        return $this->render('test/test.html.twig', compact('htmlTree', 'id', 'pagination'));
    }

    /**
     * @param $id
     * @Security("has_role('ROLE_MODERATOR')")
     * @Route(
     *     "/category/{id}/edit",
     *     requirements={"id" = "[0-9]{1,3}"},
     *     name="edit_category"
     *     )
     * @Method({"GET","POST"})
     * @return Response
     */
    public function editCategory($id)
    {
        return new Response("Page edit category granted to ROLE_MODERATOR");
    }
}
