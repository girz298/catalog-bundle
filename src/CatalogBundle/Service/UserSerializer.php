<?php
namespace CatalogBundle\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use CatalogBundle\Entity\User;
use Doctrine\ORM\EntityManager;

class UserSerializer
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
            'password',
            'salt',
            'roles',
            'userDataToForm'
        ]);


        $serializer = new Serializer([$normalizer], [$encoder]);

        $users = $this->em
            ->getRepository('CatalogBundle:User')
            ->getByPage($page, $per_page, $ordered_by, $direction);
        $response = new Response($serializer->serialize($users, 'json'));
        $response->headers->set('Content-Type', 'application/vnd.api+json');

        return $response;
    }
}
