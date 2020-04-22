<?php

namespace App\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Form\ChangePasswordByPassword;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{

    protected $security;
    private $passwordEncoder;


    /**
     * @var TranslatorInterface
     */
    private $translator;


    public function __construct(UserPasswordEncoderInterface $passwordEncoder,Security $security,TranslatorInterface  $translator)
    {        
        $this->security = $security;    
        $this->translator = $translator;
        $this->passwordEncoder = $passwordEncoder;
        
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
        else  if($this->security->isGranted('ROLE_AGENT'))
           return  $this->redirectToRoute('agent');
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
}
