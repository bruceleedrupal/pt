<?php

namespace App\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends AbstractController
{

    protected $security;


    public function __construct(Security $security)
    {        
        $this->security = $security;    
        
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


     
}
