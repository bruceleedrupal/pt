<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\SchoolSessionStorage;
use App\Form\SchoolSessionType;
use Symfony\Component\HttpFoundation\Request;

class SchoolSessionController extends AbstractController
{
    private $schoolSessionStorage;

    public function  __construct(SchoolSessionStorage  $schoolSessionStorage){
            $this->schoolSessionStorage = $schoolSessionStorage;
    }
    
    /**
     * @Route("/update-school", name="update_school", methods={"POST"})
     */
    public function selectBlock(Request $request)
    {       
        $form = $this->createForm(SchoolSessionType::class);  
        $form->handleRequest($request);

        $schoolId = $form->get('school')->getData();

        if ($form->isSubmitted() && $form->isValid()) {        
            $this->schoolSessionStorage->set($schoolId);
           return   $this->redirect($request->headers->get('referer'));
        }
        else {            
            $form->get('school')->setData($this->schoolSessionStorage->get());
            return $this->render('school_session/selectBlock.html.twig', [
                'form' => $form->createView(),
            ]);
        }
    }
}
