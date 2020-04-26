<?php

namespace App\Controller;

use App\Form\ChangePasswordByPassword;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Service\SchoolSessionStorage;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;


class SecurityController extends AbstractController
{

    protected $security;
    private $passwordEncoder;
    private $schoolSessionStorage;


    /**
     * @var TranslatorInterface
     */
    private $translator;


    public function __construct(UserPasswordEncoderInterface $passwordEncoder,Security $security,TranslatorInterface  $translator,SchoolSessionStorage $schoolSessionStorage)
    {        
        $this->security = $security;    
        $this->translator = $translator;
        $this->passwordEncoder = $passwordEncoder;
        $this->schoolSessionStorage = $schoolSessionStorage;
        
    }


    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        
      
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();    

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout(): Response
    {
        return "";
        
    }

    /**
     * @Route("/_redirect", name="redirect")
     */
    public function _redirect(): Response
    {
        if($this->security->isGranted('ROLE_ADMIN'))
           return  $this->redirectToRoute('admin');
        else  if($this->security->isGranted('ROLE_AGENT')) {
            $this->schoolSessionStorage->validateSchool();
            return  $this->redirectToRoute('agent');

        }   
        else
        return  new Response('');        
    }

     /**
     * @Route("/changepassword/bypassword", name="changepassword_bypassword")
     *  @IsGranted("ROLE_USER")
     */
    public function changepassword_bypassword(Request $request)
    {   
        $form = $this->createForm(ChangePasswordByPassword::class);
        $form->handleRequest($request);
        $message = '';
        
        if ($form->isSubmitted() && $form->isValid()) {
            $checkPassword = $form->get('checkPassword')->getData();
            $newPassword = $form->get('newPassword')->getData();
            $user = $this->getUser();
            if($this->passwordEncoder->isPasswordValid($user, $checkPassword)){
                $user->setPassword(
                    $this->passwordEncoder->encodePassword(
                        $user,
                        $newPassword
                )
            );
            
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('warning',$this->translator ->trans('Your password has been updated'));
            return $this->redirectToRoute('redirect');           
            } else {                       
              $message =$this->translator ->trans('You password is not correct');                
            }            
        }
        
        return $this->render('security/changePassword/byPassword.html.twig', [
            'form' => $form->createView(),
            'message'=>$message,
        ]);
   }



    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder,UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
             $mobile =$user->getMobile();
             $existUser = $userRepository->findOneBy(['mobile'=>$mobile]);
            if($existUser) {
                return $this->render('registration/register.html.twig', [
                    'registrationForm' => $form->createView(),
                    'error' =>'该手机号已注册'
                ]);
            }



            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $user->setRoles(['ROLE_AGENT']);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email
            $this->_authenticateUser($user);

            return $this->redirectToRoute('student');
        }


    
        return $this->render('registration/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }



    private function _authenticateUser(User $user)
    {
        $providerKey = 'main';
        $token = new UsernamePasswordToken($user, null, $providerKey, $user->getRoles());
        $this->container->get('security.token_storage')->setToken($token);
        $this->schoolSessionStorage->validateSchool();
    } 
}
