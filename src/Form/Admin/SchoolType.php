<?php

namespace App\Form\Admin;

use App\Entity\School;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\SchoolType  as baseSchoolType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class SchoolType extends baseSchoolType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder,$options);
        $builder            
             ->add('commission',NumberType::class,[
                "html5"=>true,
                "attr"=>[                    
                    'class'=>'form-control',            
                    'step'=>0.05,
                    'min'=>0.1,
                    'max'=>0.5                    
                 ]
            ]) 
            ->add('status',ChoiceType::class,[
                'choices'  =>[
                   '待审核' => false,
                   '已审核' => true,
                ],
                'attr'=>[
                    'class'=>'form-control',
                ]
            ])
            
            ;
    }


}
