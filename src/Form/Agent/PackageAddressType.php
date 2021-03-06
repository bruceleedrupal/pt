<?php

namespace App\Form\Agent;

use App\Entity\PackageAddress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PackageAddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
         ->add('title',NULL,[
            'label'=>'地点',
         'attr'=>[
          'class'=>'form-control'
         ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PackageAddress::class,
        ]);
    }
}
