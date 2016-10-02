<?php
namespace CatalogBundle\Form\Product;

use CatalogBundle\Form\Type\CategoryType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class BasicProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image', FileType::class, [
                'attr' => [
                    'label' => 'Image File',
                    'class' => 'file',
                    'style' => 'margin-bottom:15px;',
                    'data-allowed-file-extensions' => '["jpg", "png"]'
                ],
                'required' => false,
            ])
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'margin-bottom:15px;'
                ]
            ])
            ->add('category', CategoryType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'margin-bottom:15px'
                ]
            ])
            ->add('sku', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'margin-bottom:15px'
                ]
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'margin-bottom:15px'
                ]
            ])
            ->add('first_similar_product_id', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'margin-bottom:15px',
                ],
                'required' => false,
                'empty_data' => null,
            ])
            ->add('second_similar_product_id', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'margin-bottom:15px',
                ],
                'required' => false,
                'empty_data' => null,
            ])
            ->add('third_similar_product_id', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'margin-bottom:15px',
                ],
                'required' => false,
                'empty_data' => null,
            ])
            ->add('state_flag', CheckboxType::class, [
                'attr' => [
                    'class' => 'checkbox-inline',
                    'style' => 'margin: 10px;'
                ],
                'required' => false,
                'empty_data' => false,
            ]);
    }
}