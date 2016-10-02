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
     *     "/category/all",
     *     name="products_all"
     * )
     * @Security("has_role('ROLE_USER')")
     * @Method({"GET"})
     * @return Response
     */
    public function getAllProducts(Request $request)
    {
        $per_page = $request->get('per_page') ? $request->get('per_page') : 8;
        $paginator = $this->get('knp_paginator');
        $pagination = $this
            ->get('app.category_paginator_generator')
            ->getPaginator($request, $paginator, 'all', $per_page);

        $htmlTree = $this->get('app.category_menu_generator')->getMenu();
        return $this->render('test/test.html.twig', compact('htmlTree', 'id', 'pagination'));
    }

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
        $per_page = $request->get('per_page') ? $request->get('per_page') : 8;
        $paginator = $this->get('knp_paginator');
        $pagination = $this
            ->get('app.category_paginator_generator')
            ->getPaginator($request, $paginator, $id, $per_page);

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
