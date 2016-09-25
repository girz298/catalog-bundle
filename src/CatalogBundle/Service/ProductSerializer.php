<?php
namespace CatalogBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;

class ProductSerializer
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param $page
     * @param $per_page
     * @param $ordered_by
     * @param $direction
     * @return Response
     */
    public function serializeProducts(
        $page,
        $per_page,
        $ordered_by,
        $direction
    ) {

        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getName();
        });

        $normalizer->setCircularReferenceLimit(0);
        $normalizer->setIgnoredAttributes([
            'creationTime',
            'lastModification',
            'similarProducts',
            'image',
            'parent',
            'children',
            'products'
        ]);

        $serializer = new Serializer([$normalizer], [$encoder]);

        $products = $this->em
            ->getRepository('CatalogBundle:Product')
            ->getByPage($page, $per_page, $ordered_by, $direction);
        $response = new Response($serializer->serialize($products, 'json'));
        $response->headers->set('Content-Type', 'application/vnd.api+json');

        return $response;
    }
}