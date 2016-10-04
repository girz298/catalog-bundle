<?php
namespace CatalogBundle\Controller;

use CatalogBundle\Entity\Category;
use CatalogBundle\Form\Category\SubmitCategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class CategoryController extends Controller
{

    /**
     * @param $request
     * @Route(
     *     "/category/all",
     *     name="products_all"
     * )
     * @Security("has_role('ROLE_USER')")
     * @Method({"GET"})
     * @return Response
     */
    public function getAllProductsAction(Request $request)
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
     * @Security("has_role('ROLE_MODERATOR')")
     * @Route(
     *     "/category/crud",
     *     name="category_crud"
     *     )
     * @Method({"GET","POST"})
     * @return Response
     */
    public function crudCategoryAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('CatalogBundle:Category');
        $options = array(
            'decorate' => true,
            'rootOpen' => '<ul>',
            'rootClose' => '</ul>',
            'childOpen' => '<li style="margin-bottom:15px;margin-top: 15px;">',
            'childClose' => '</li>',
            'nodeDecorator' => function ($node) {
                return '<a href="/category/' . $node['id'] . '">' . $node['title'] . '</a>
                <a href="/category/' . $node['id'] .
                '/edit"  class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-pencil"></span></a>
                <a href="/category/' . $node['id'] .
                '/remove" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-remove"></span></a>';
            }
        );
        $htmlTree = $repo->childrenHierarchy(
            null, /* starting from root nodes */
            false, /* false: load all children, true: only direct */
            $options
        );

        return $this->render('category/category_crud.html.twig', compact('htmlTree'));
    }


    /**
     * @param Post
     * @Security("has_role('ROLE_MODERATOR')")
     * @Route(
     *     "/category/{id}/remove",
     *     requirements={"id" = "[0-9]+"},
     *     name="category_remove"
     * )
     * @Method({"GET","POST"})
     * @return Response
     */
    public function removeCategoryAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $categoryRepo = $em->getRepository('CatalogBundle:Category');
//        $categoryRepo->removeFromTree($categoryRepo->findOneById($id));
        $em->remove($categoryRepo->findOneById($id));
        $em->flush();
        return $this->redirectToRoute('category_crud');
    }

    /**
     * @param $request
     * @Security("has_role('ROLE_MODERATOR')")
     * @Route(
     *     "/category/create",
     *     name="category_create"
     * )
     * @Method({"GET","POST"})
     * @return Response
     */
    public function createCategoryAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(SubmitCategoryType::class);
        $categoryRepo = $em->getRepository('CatalogBundle:Category');
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $category = new Category();
            if (!is_null($form->get('parent_category')->getData())) {
                $category->setParent(
                    $categoryRepo->findOneById($form->get('parent_category')->getData())
                );
            }
            $category->setTitle($form->get('title')->getData());
            $category->setStateFlag($form->get('state_flag')->getData());
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('category_crud');
        }

        return $this->render('category/category_add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param $request
     * @param $id
     * @Security("has_role('ROLE_MODERATOR')")
     * @Route(
     *     "/category/{id}/edit",
     *     requirements={"id" = "[0-9]+"},
     *     name="category_edit"
     * )
     * @Method({"GET","POST"})
     * @return Response
     */
    public function editCategoryAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $categoryRepo = $em->getRepository('CatalogBundle:Category');
        $category =  $categoryRepo->findOneById($id);

        $form = $this->createForm(SubmitCategoryType::class);
        $form->setData($category->getDataToForm());

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if (!is_null($form->get('parent_category')->getData())) {
                $category->setParent(
                    $categoryRepo->findOneById($form->get('parent_category')->getData())
                );
            }
            $category->setTitle($form->get('title')->getData());
            $category->setStateFlag($form->get('state_flag')->getData());
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('category_crud');
        }

        return $this->render('category/category_add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}


