<?php

namespace App\Form\Agent;

use App\Entity\PackageSize;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PackageSizeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
         ->add('title',NULL,[
            'label'=>'规格'
        ])
        ->add('price',NULL,[
            'label'=>'价格'
           ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PackageSize::class,
        ]);
    }
}
