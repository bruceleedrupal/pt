<?php

namespace App\Form\Agent;

use App\Entity\ReceiveAddress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReceiveAddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
	->add('title',NULL,[
	  'attr'=>[
	  'class'=>'form-control'
	  ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ReceiveAddress::class,
        ]);
    }
}
