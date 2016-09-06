<?php

namespace CatalogBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
            'attr' => [
                'class' => 'form-control',
                'style' => 'margin-bottom:15px'
            ]
            ])
            ->add('password', PasswordType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'margin-bottom:15px'
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'margin-bottom:15px'
                ]
            ])
            ->add('role', ChoiceType::class, [
                'choices' => [
                    'ROLE_USER' => 'ROLE_USER',
                    'ROLE_MODERATOR' => 'ROLE_MODERATOR',
                    'ROLE_ADMIN' => 'ROLE_ADMIN'],
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'margin-bottom:15px'
                ]
            ])
            ->add('is_active', CheckboxType::class, [
                'attr' => [
                    'class' => 'checkbox-inline',
                    'style' => 'margin:10px'
                ]])
            ->add('save', SubmitType::class, [
                'label' =>
                    'Submit','attr' =>
                    [
                        'class' => 'btn btn-primary',
                        'style' => 'margin-bottom:15px'
                    ]
            ]);
    }
}