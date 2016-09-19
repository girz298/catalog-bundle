<?php
namespace CatalogBundle\Service;

use Doctrine\ORM\EntityManager;

class CategoryMenuGenerator
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getMenu()
    {
        $repo = $this->em->getRepository('CatalogBundle:Category');
        $options = [
            'decorate' => true,
            'rootOpen' => '<ul>',
            'rootClose' => '</ul>',
            'childOpen' => function ($tree) {
                if (count($tree)
                    && ($tree['lvl'] >= 0)
                    && count($tree['__children']) > 0) {
                    return '<li class="has-sub">';
                } else {
                    return '<li>';
                }
            },
            'childClose' => function ($child) {
                return '</li>';
            },
            'nodeDecorator' => function ($node) {
                return '<a href="/category/' . $node['id'] . '">' . $node['title'] . '</a>';
            }
        ];
        $htmlTree = $repo->childrenHierarchy(
            null,
            false,
            $options
        );
        return $htmlTree;
    }
}
