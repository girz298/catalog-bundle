<?php
namespace CatalogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CatalogBundle\Entity\Product;

class LoadProductData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $repo = $manager->getRepository('CatalogBundle:Category');
        $category = $repo->findOneByTitle('Гаджеты');

        for ($i = 0; $i < 20; $i++) {
            $now = new\DateTime('now');
            $product = new Product();
            $product->setName("Rolex");
            $product->setStateFlag(true);
            $product->setCategory($category);
            $product->setDescription("good watch");
            $product->setSku(mt_rand(1, 10000));
            $product->setCreationTime($now);
            $product->setLastModification($now);
            $product->addSimilarProduct($product);
            $manager->persist($product);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}
