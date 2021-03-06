<?php

namespace App\Form\Admin;

use App\Entity\School;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;


class SchoolType  extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder,$options);
        $builder   
           ->add('title',NULL,[            
            'label'=>'学校(校区)'  ,
            "attr"=>[                
                'placeHolder'=>'有多个校区请加上校区'
             ]
            ])         
             ->add('commission',NumberType::class,[
                'label'=>'佣金',
                "html5"=>true,
                "attr"=>[                                        
                    'step'=>0.01,
                    'min'=>0.1,
                    'max'=>0.5                    
                 ]
            ]) 
            ->add('status',ChoiceType::class,[
                'label'=>'状态'  ,
                'choices'  =>[
                   '待审核' => false,
                   '已审核' => true,
                ]
            ])
            
            ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => School::class,
        ]);
    }


}
