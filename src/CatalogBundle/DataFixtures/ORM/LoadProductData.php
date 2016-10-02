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
        $category = $repo->findOneByTitle('Прочее');

        for ($i = 0; $i < 20; $i++) {
            $now = new\DateTime('now');
            $product = new Product();
            $product->setName('Rolex');
            $product->setStateFlag(true);
            $product->setCategory($category);
            $product->setDescription('Lorem ipsum dolor sit amet, consectetur adipisicing elit.
             Accusamus amet aspernatur fugiat mollitia perspiciatis provident quasi quis 
             quisquam, sunt tempore. Adipisci cumque deserunt doloremque ipsam, laudantium 
             quam quos voluptas voluptatum.');
            $product->setImage('91bf6f17b8196330930561b887e94b85.png');
            $product->setSku($i+100);
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
