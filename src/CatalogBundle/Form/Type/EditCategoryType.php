<?php

namespace CatalogBundle\Form\Type;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EditCategoryType extends AbstractType
{
    private $em;
    private $categoryChoices;
    private $validCategories;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $this->categoryChoices = $this->em
            ->getRepository('CatalogBundle:Category')
            ->getAllByIdNameLvl();

        $this->validCategories['NULL'] = null;
        foreach ($this->categoryChoices as $key => $value) {
            if ((int)$value['lvl'] <= 1) {
                $this->validCategories[str_repeat('└─', (int)$value['lvl']) . $value['title']] = $value['id'];
            } else {
                $this->validCategories['└─' . str_repeat('─', (int)$value['lvl']-1) . $value['title']] = $value['id'];
            }
        }

        $resolver->setDefaults([
            'choices' => $this->validCategories
        ]);
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}