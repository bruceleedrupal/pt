<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SchoolSessionType extends AbstractType
{
    private $security;

    public function __construct(Security $security) {
            $this->security =  $security;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $schools = $this->security->getUser()->getSchools();

        $choices   = ['选择学校(校区)'=>NULL];
        foreach($schools as $school) {
           $choices[$school->getTitle()] = $school->getId();
        }
        
        $builder
            ->add('school',ChoiceType::class,[
                'label'=>false,
                'attr'=>['onchange'=>"this.form.submit();"],
                'choices'  => $choices
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
