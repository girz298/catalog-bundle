<?php
/**
 * Created by PhpStorm.
 * User: doctor
 * Date: 06.09.16
 * Time: 17:56
 */

namespace CatalogBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserType extends BasicUserType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
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