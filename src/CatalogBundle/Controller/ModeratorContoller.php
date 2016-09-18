<?php
/**
 * Created by PhpStorm.
 * User: doctor
 * Date: 03.09.16
 * Time: 15:08
 */

namespace CatalogBundle\Controller;

use CatalogBundle\Entity\Product;
use CatalogBundle\Entity\Category;

use CatalogBundle\Form\BasicProductType;
use CatalogBundle\Form\SubmitProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Validator\Constraints\DateTime;


class ModeratorContoller extends Controller
{
    /**
     * @param $scu
     * @Security("has_role('ROLE_MODERATOR')")
     * @Route("/product/{scu}/edit", name="product_edit")
     * @Method({"GET","POST"})
     * @return Response
     */
    public function editProduct($scu)
    {
        return new Response("Page edit product granted to ROLE_MODERATOR " . $scu);
    }

    /**
     * @Security("has_role('ROLE_MODERATOR')")
     * @Route("/product/crud", name="product_crud")
     * @Method({"GET","POST"})
     * @return Response
     */
    public function gridProducts()
    {
        return $this->render('moderator/product_crud.html.twig');
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

    /**
     * @param Post
     * @Security("has_role('ROLE_MODERATOR')")
     * @Route("/product/create", name="product_create")
     * @Method({"GET","POST"})
     * @return Response
     */
    public function createProduct(Request $request){

        $em = $this->getDoctrine()->getManager();

        $product = new Product();
        $now = new\DateTime('now');


//        $sameCategory = $em->getRepository('CatalogBundle:Category')
//            ->findOneByTitle('Bags');

        $product->setCreationTime($now);
        $product->setLastModification($now);
//        $product->setCategory($sameCategory);
        $form = $this->createForm(SubmitProductType::class, $product);



        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $product = $form->getData();
            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute('index');

        }

        return $this->render('moderator/add_product.html.twig',[
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
        if ($product === null){
            return new Response('0');
        } else {
            $em->remove($product);
            $em->flush();
            return new Response('1');
        }
    }
}