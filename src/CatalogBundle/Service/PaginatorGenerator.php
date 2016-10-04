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

    public function getPaginator(Request $request, $paginator, $id, $per_page)
    {
        if (!preg_match('/[0-9]{1,2}/', $per_page)) {
            $per_page = 8;
        }

        $query = $this->em
            ->createQueryBuilder()
            ->select('p')
            ->from('CatalogBundle:Product', 'p')
            ->where('p.category=' . $id)
            ->getQuery();

        if ($id === 'all') {
            $query = $this->em
                ->createQueryBuilder()
                ->select('p')
                ->from('CatalogBundle:Product', 'p')
                ->getQuery();
        }

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $per_page
        );

        return $pagination;
    }
}