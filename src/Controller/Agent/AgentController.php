<?php

namespace App\Controller\Agent;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
* @IsGranted("ROLE_AGENT")
*/

class AgentController extends AbstractController
{
    /**
     * @Route("/agent", name="agent")
     */
    public function index()
    {
        return $this->render('agent/index.html.twig', [
            'controller_name' => 'AgentController',
        ]);
    }
}
