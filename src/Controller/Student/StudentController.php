<?php

namespace App\Controller\Student;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;


class StudentController extends AbstractController
{
    protected $security;


    public function __construct(Security $security)
    {        
        $this->security = $security;    
        
    }

    /**
     * @Route("/student", name="student")
     */
    public function index()
    {
        $user =  $this->security->getUser();
     
    
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }
}
