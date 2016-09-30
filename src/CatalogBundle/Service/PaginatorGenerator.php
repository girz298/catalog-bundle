<?php
namespace CatalogBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;

class PaginatorGenerator
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getPaginator(Request $request, $paginator, $id)
    {
        $query = $this->em
            ->createQueryBuilder()
            ->select('p')
            ->from('CatalogBundle:Product', 'p')
            ->where('p.category=' . $id)
            ->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            8
        );

        return $pagination;
    }
}