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
     * @Route("/api/products", name="api_per_page")
     * @return Response
     */
    public function getProductsByPageAction(Request $request)
    {
        //products?page=1&per_page=5&ordered_by=id&direction=1
        $page = $request->get('page') ? $request->get('page') : 1;
        $per_page = $request->get('per_page') ? $request->get('per_page') : 5;
        $ordered_by = $request->get('ordered_by') ? $request->get('ordered_by') : 'id';
        $direction = $request->get('direction') ? $request->get('direction') : 0;

        $result = $this
            ->get('app.product_serializer')
            ->serializeProducts(
                $page,
                $per_page,
                $ordered_by,
                $direction
            );

        return $result;
    }
}