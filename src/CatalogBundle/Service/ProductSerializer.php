<?php
namespace CatalogBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;

class ProductSerializer
{
    /**
     * @param EntityManager $em
     * @param Serializer $serializer
     * @param $page
     * @param $per_page
     * @param $ordered_by
     * @param $direction
     * @return Response
     */
    public function serializeProducts(
        EntityManager $em,
        Serializer $serializer,
        $page,
        $per_page,
        $ordered_by,
        $direction
    ) {
        $products = $em
            ->getRepository('CatalogBundle:Product')
            ->getByPage($page, $per_page, $ordered_by, $direction);

        $response = new Response($serializer->serialize($products, 'json'));
        $response->headers->set('Content-Type', 'application/vnd.api+json');

        return $response;
    }
}