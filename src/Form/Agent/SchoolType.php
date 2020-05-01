<?php

namespace App\Form\Agent;

use App\Entity\School;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class SchoolType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',NULL,[            
            'label'=>'名称',
            "attr"=>[                
                'placeHolder'=>'有多个校区请加上校区'
             ]
            ])
            ->add('assistantCommission',NumberType::class,[            
                "html5"=>true,
                'label'=>'骑手佣金',
                "attr"=>[                                        
                    'step'=>0.01,
                    'min'=>0.1,
                    'max'=>0.9
               ]
          ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => School::class,
        ]);
    }
}
