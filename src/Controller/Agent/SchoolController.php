<?php

namespace App\Controller\Agent;

use App\Entity\School;
use App\Form\Agent\SchoolType;
use App\Repository\SchoolRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/agent/school")
 * @IsGranted("ROLE_AGENT")
 */
class SchoolController extends AbstractController
{
    protected $security;


    public function __construct(Security $security)
    {        
        $this->security = $security;    
        
    }

    /**
     * @Route("/", name="agent_school_index", methods={"GET"})
     */
    public function index(SchoolRepository $schoolRepository): Response
    {
        $qb =$schoolRepository->findAllSchoolQueryBuilder();
        $qb->andWhere('s.agent = :agent')->setParameter('agent', $this->getUser());        
        $schools = $qb->getQuery()->execute();

        return $this->render('agent/school/index.html.twig', [
            'schools' => $schools,
        ]);
    }

    /**
     * @Route("/new", name="agent_school_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $school = new School();
        $form = $this->createForm(SchoolType::class, $school);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $school->setAgent($this->security->getUser());            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($school);
            $entityManager->flush();

            return $this->redirectToRoute('agent_school_index');
        }

        return $this->render('agent/school/new.html.twig', [
            'school' => $school,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="agent_school_show", methods={"GET"})
     */
    public function show(School $school): Response
    {
        return $this->render('agent/school/show.html.twig', [
            'school' => $school,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="agent_school_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, School $school): Response
    {
      
        $this->denyAccessUnlessGranted('edit',$school);

        $form = $this->createForm(SchoolType::class, $school);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('agent_school_index');
        }

        return $this->render('agent/school/edit.html.twig', [
            'school' => $school,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="agent_school_delete", methods={"DELETE"})
     */
    public function delete(Request $request, School $school): Response
    {
        $this->denyAccessUnlessGranted('delete',$school);

        if ($this->isCsrfTokenValid('delete'.$school->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($school);
            $entityManager->flush();
        }

        return $this->redirectToRoute('agent_school_index');
    }
}
