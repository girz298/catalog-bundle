<?php
namespace CatalogBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;

class ProductAPIService
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
        )
    {
        $directionDQL = 'ASC';
        if ($direction){
            $directionDQL = 'ASC';
        } else {
            $directionDQL = 'DESC';
        }

        $products = $em
            ->createQueryBuilder()
            ->select('p')
            ->from('CatalogBundle:Product','p')
            ->orderBy('p.' . $ordered_by, $directionDQL)
            ->setFirstResult(($page-1)*$per_page)
            ->setMaxResults($per_page)
            ->getQuery()
            ->getResult();

        $response = new Response($serializer->serialize($products,'json'));
//        $response = new Response(json_encode($products));
        $response->headers->set('Content-Type', 'application/vnd.api+json');

        return $response;
    }
}