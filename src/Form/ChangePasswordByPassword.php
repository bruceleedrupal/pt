<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ChangePasswordByPassword extends AbstractType
{
    /**
     * @var TranslatorInterface
     */
    private $translator;
    
    public function __construct(TranslatorInterface  $translator)
    {
        $this->translator = $translator;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('checkPassword',PasswordType::class,
            ["attr"=>[
                'placeHolder'=>"Original Password"
            ]
        ])
       
        ->add('newPassword',PasswordType::class,
            ["attr"=>[
                'placeHolder'=>"New Password"
            ]
        ])
        ->add('submit',SubmitType::class,[
            'label'=>'Submit'
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
        
        ]);
    }
}
