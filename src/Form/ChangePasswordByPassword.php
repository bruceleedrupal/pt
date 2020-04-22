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
use Symfony\Component\Validator\Constraints\NotBlank;

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
                'placeHolder'=>"原密码",
                'class'=>'form-control',
                ],
               'constraints' => [
                new NotBlank([
                    'message' => '请输入手机号'
               ])
               ]
         ]) 
        ->add('newPassword',PasswordType::class,
            ["attr"=>[
                'placeHolder'=>"新密码",
                'class'=>'form-control',
            ]
        ])
   
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
        
        ]);
    }
}
