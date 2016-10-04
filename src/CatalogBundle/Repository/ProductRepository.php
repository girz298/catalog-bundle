<?php
namespace CatalogBundle\Repository;

use Doctrine\ORM\EntityRepository;
use CatalogBundle\Entity\Category;
use Symfony\Component\Form\Form;
use CatalogBundle\Entity\Product;

class ProductRepository extends EntityRepository
{
    public function getByPage($page, $per_page, $ordered_by, $direction)
    {
        if ($direction) {
            $directionDQL = 'ASC';
        } else {
            $directionDQL = 'DESC';
        }

        $products = $this->_em
            ->createQueryBuilder()
            ->select('p')
            ->from('CatalogBundle:Product', 'p')
            ->orderBy('p.' . $ordered_by, $directionDQL)
            ->setFirstResult(($page-1)*$per_page)
            ->setMaxResults($per_page)
            ->getQuery()
            ->getResult();

        return $products;
    }

    public function getByCategory($category_id)
    {

        $products = $this->_em
            ->createQueryBuilder()
            ->select('p')
            ->from('CatalogBundle:Product', 'p')
            ->where('p.category=' . $category_id)
            ->getQuery();

        return $products;
    }

    public function insertDataFromForm(Form $form)
    {
        /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
        $file = $form->get('image')->getData();
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        $file->move(
            'uploads/images',
            $fileName
        );

        $now = new\DateTime('now');
        $product = new Product();
        $product->setName($form->get('name')->getData());
        $product->setStateFlag($form->get('state_flag')->getData());
        if (!is_null($form->get('first_similar_product_id')) &&
            !is_null($this->findOneById($form->get('first_similar_product_id')->getData()))
        ) {
            $product = $this->findOneById($form->get('first_similar_product_id')->getData());
            $product->addSimilarProduct($product);
            $product->addSimilarProduct($product);
        }
        if (!is_null($form->get('second_similar_product_id')) &&
            !is_null($this->findOneById($form->get('second_similar_product_id')->getData()))
            ) {
            $product = $this->findOneById($form->get('second_similar_product_id')->getData());
            $product->addSimilarProduct($product);
            $product->addSimilarProduct($product);
        }
        if (!is_null($form->get('third_similar_product_id')) &&
            !is_null($this->findOneById($form->get('third_similar_product_id')->getData()))
        ) {
            $product = $this->findOneById($form->get('third_similar_product_id')->getData());
            $product->addSimilarProduct($product);
            $product->addSimilarProduct($product);
        }
        $product->setCategory(
            $this->_em
                ->getRepository('CatalogBundle:Category')
                ->findOneById($form->get('category')->getData())
        );

        $product->setDescription($form->get('description')->getData());
        $product->setSku($form->get('sku')->getData());
        $product->setCreationTime($now);
        $product->setLastModification($now);
        $product->setImage($fileName);
        $this->_em->persist($product);
        $this->_em->flush();
    }

    public function updateDataFromForm(Form $form, Product $product)
    {
        if (!is_null($form->get('image')->getData())) {
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $form->get('image')->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                'uploads/images',
                $fileName
            );
            $product->setImage($fileName);
        }
        $now = new\DateTime('now');
        $product
            ->setName($form->get('name')->getData());
        $product->setStateFlag($form->get('state_flag')->getData());
        $product->removeAllSimilarProducts();
        if (!is_null($form->get('first_similar_product_id')) &&
            !is_null($this->findOneById($form->get('first_similar_product_id')->getData()))
        ) {
            $product->addSimilarProduct(
                $this->findOneById($form->get('first_similar_product_id')->getData())
            );
        }
        if (!is_null($form->get('second_similar_product_id')) &&
            !is_null($this->findOneById($form->get('second_similar_product_id')->getData()))
        ) {
            $product->addSimilarProduct(
                $this->findOneById($form->get('second_similar_product_id')->getData())
            );
        }
        if (!is_null($form->get('third_similar_product_id')) &&
            !is_null($this->findOneById($form->get('third_similar_product_id')->getData()))
        ) {
            $product->addSimilarProduct(
                $this->findOneById($form->get('third_similar_product_id')->getData())
            );
        }
        $product->setCategory(
            $this->_em
                ->getRepository('CatalogBundle:Category')
                ->findOneById($form->get('category')->getData())
        );

        $product->setDescription($form->get('description')->getData());
        $product->setSku($form->get('sku')->getData());
        $product->setLastModification($now);
        $this->_em->persist($product);
        $this->_em->flush();
    }
}
