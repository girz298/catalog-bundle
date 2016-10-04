<?php
namespace CatalogBundle\Form\Category;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use CatalogBundle\Form\Type\EditCategoryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class SubmitCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'margin-bottom:15px;'
                ]
            ])
            ->add('parent_category', EditCategoryType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'margin-bottom:15px'
                ]
            ])
            ->add('state_flag', CheckboxType::class, [
                'attr' => [
                    'class' => 'checkbox-inline',
                    'style' => 'margin: 10px;'
                ],
                'required' => false,
                'empty_data' => false,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Submit',
                'attr' => [
                    'class' => 'btn btn-primary',
                    'style' => 'margin-bottom:15px'
                ]
            ]);
    }
}
