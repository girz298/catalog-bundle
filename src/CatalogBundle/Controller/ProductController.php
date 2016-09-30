<?php
namespace CatalogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use CatalogBundle\Form\SubmitProductType;
use CatalogBundle\Entity\Product;

class ProductController extends Controller
{
    /**
     * @param $request
     * @param $id
     * @Security("has_role('ROLE_MODERATOR')")
     * @Route(
     *     "/product/{id}/edit",
     *     requirements={"id" = "[0-9]+"},
     *     name="product_edit"
     * )
     * @Method({"GET","POST"})
     * @return Response
     */
    public function editProduct(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $editable_product = $em
            ->getRepository('CatalogBundle:Product')
            ->findOneById($id);
        $form = $this->createForm(SubmitProductType::class);
        $form->setData($editable_product->getProductDataToForm());
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $now = new\DateTime('now');
            $editable_product->setName($form->get('name')->getData());
            $editable_product->setStateFlag($form->get('state_flag')->getData());
            $editable_product->setCategory(
                $em
                    ->getRepository('CatalogBundle:Category')
                    ->findOneById($form->get('category')->getData())
            );
            $editable_product->setDescription($form->get('description')->getData());
            $editable_product->setSku($form->get('sku')->getData());
            $editable_product->setLastModification($now);
            $em->persist($editable_product);
            $em->flush();

            return $this->redirectToRoute('product_crud');
        }

        return $this->render('moderator/add_product.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Security("has_role('ROLE_MODERATOR')")
     * @Route("/product/crud", name="product_crud")
     * @Method({"GET"})
     */
    public function gridProducts()
    {
        return $this->render('moderator/product_crud.html.twig');
    }

    /**
     * @param Request $request
     * @Security("has_role('ROLE_MODERATOR')")
     * @Route("/product/create", name="product_create")
     * @Method({"GET","POST"})
     * @return Response
     */
    public function createProduct(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(SubmitProductType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em->getRepository('CatalogBundle:Product')->insertDataFromForm($form);
            return $this->redirectToRoute('product_crud');
        }

        return $this->render('moderator/add_product.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Post
     * @Security("has_role('ROLE_MODERATOR')")
     * @Route(
     *     "/product/{id}/remove",
     *     requirements={"id" = "[0-9]{1,3}"},
     *     name="product_remove"
     * )
     * @Method({"GET","POST"})
     * @return Response
     */
    public function removeProduct($id)
    {
        $em = $this->getDoctrine()->getManager();
        $prodRepo = $em->getRepository('CatalogBundle:Product');
        $product = $prodRepo->findOneById($id);
        if ($product === null) {
            return new Response('0');
        } else {
            $em->remove($product);
            $em->flush();
            return new Response('1');
        }
    }

    /**
     * @param $id
     * @Route(
     *     "/product/{id}",
     *     name="product_by_id"
     * )
     * @Security("has_role('ROLE_USER')")
     * @Method({"GET"})
     * @return Response
     */
    public function getProductByIdAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('CatalogBundle:Product');
        $product = $repo->findOneById($id);
        $htmlTree = $this->get('app.category_menu_generator')->getMenu();
        return $this->render('test/test.html.twig', compact('htmlTree', 'product'));
    }
}
