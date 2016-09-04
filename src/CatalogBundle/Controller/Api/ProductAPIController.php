<?php
namespace CatalogBundle\Controller\Api;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ProductAPIController extends Controller
{
    /**
     * @Security("has_role('ROLE_MODERATOR')")
     * @Route(
     *     "/api/products/{page}/{per_page}/{ordered_by}/{direction}",
     *     requirements={
     *          "page" = "[0-9]{1,3}",
     *          "per_page" = "[0-9]{1,3}"
     *     },
     *     defaults={
     *          "page" = 1,
     *          "per_page" = 100,
     *          "ordered_by" = "id",
     *          "direction" = 1
     *     },
     *     name = "api_per_page"
     *     )
     * @return Response
     */
    public function getProductsByPageAction($page, $per_page, $ordered_by, $direction)
    {
        // api/products/1/5/name/1
        $em = $this->getDoctrine()->getManager();

        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getName();
        });

        $serializer = new Serializer([$normalizer], [$encoder]);

        $result = $this
            ->get('app.product_api_service')
            ->serializeProducts($em, $serializer, $page,
                $per_page, $ordered_by ,$direction);

        return $result;
    }
}