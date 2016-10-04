<?php
/**
 * Created by PhpStorm.
 * User: doctor
 * Date: 04.10.16
 * Time: 12:11
 */

namespace CatalogBundle\Form\User;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class ForgivePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'margin-bottom:15px'
                ]
            ])
            ->add('send', SubmitType::class, [
                'label' => 'Submit',
                'attr' => [
                    'class' => 'btn btn-primary',
                    'style' => 'margin-bottom:15px'
                ]
            ]);
    }
}
