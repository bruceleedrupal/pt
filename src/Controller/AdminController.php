<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ChangePasswordByPassword;
/**
 * @Route("/admin")
 * @IsGranted("ROLE_ADMIN")
 */
class AdminController extends AbstractController
{
    protected $security;


    public function __construct(Security $security)
    {        
        $this->security = $security;    
        
    }

    /**
     * @Route("/", name="admin")
     */
    public function index()
    { 
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }


}
