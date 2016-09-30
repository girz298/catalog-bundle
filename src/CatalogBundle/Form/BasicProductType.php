<?php
/**
 * Created by PhpStorm.
 * User: doctor
 * Date: 08.09.16
 * Time: 19:14
 */

namespace CatalogBundle\Form;

use CatalogBundle\Form\Type\CategoryType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
                    'class' => 'form_control',
                    'style' => 'margin-bottom:15px'
                ]
            ])
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'margin-bottom:15px'
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
            ->add('state_flag', CheckboxType::class, [
                'attr' => [
                    'class' => 'checkbox-inline',
                    'style' => 'margin: 10px;'
                ]
            ]);
    }
}