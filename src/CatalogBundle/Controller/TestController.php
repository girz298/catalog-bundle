<?php

namespace CatalogBundle\Controller;

use CatalogBundle\Entity\Category;
use CatalogBundle\Entity\Product;
use CatalogBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class TestController extends Controller
{
    /**
     * @Route("/test_entities")
     */
    public function indexAction()
    {
        $htmlTree = $this->get('app.category_menu_generator')->getMenu();
        return $this->render('test/test.html.twig', compact('htmlTree'));
    }
}
