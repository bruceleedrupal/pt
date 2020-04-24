<?php

namespace App\Controller;

use App\Entity\School;
use App\Form\Admin\SchoolType;
use App\Repository\SchoolRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Security;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/admin/school")
 * @IsGranted("ROLE_ADMIN")
 */
class AdminSchoolController extends AbstractController
{
    protected $security;
    private $paginator;  

    public function __construct(Security $security,PaginatorInterface $paginator)
    {        
        $this->security = $security;    
        $this->paginator = $paginator;        
    }

    /**
     * @Route("/", name="admin_school_index", methods={"GET"})
     */
    public function index(SchoolRepository $schoolRepository,Request $request): Response
    {
        $qb =$schoolRepository->findAllSchoolQueryBuilder();               

        $schools = $this->paginator->paginate(
            // Doctrine Query, not results
            $qb->getQuery(),
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            10
            );

        return $this->render('admin/school/index.html.twig', [
            'schools' => $schools,
        ]);
    }

    

    /**
     * @Route("/{id}", name="admin_school_show", methods={"GET"})
     */
    public function show(School $school): Response
    {
        return $this->render('admin/school/show.html.twig', [
            'school' => $school,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_school_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, School $school): Response
    {
      
        $this->denyAccessUnlessGranted('edit',$school);

        $form = $this->createForm(SchoolType::class, $school);
        $form->handleRequest($request);

        $errors = $form->get('commission')->getErrors();
     


        if ($form->isSubmitted() && $form->isValid()) {
         

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_school_index');
        }

        return $this->render('admin/school/edit.html.twig', [
            'school' => $school,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_school_delete", methods={"DELETE"})
     */
    public function delete(Request $request, School $school): Response
    {
        $this->denyAccessUnlessGranted('delete',$school);

        if ($this->isCsrfTokenValid('delete'.$school->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($school);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_school_index');
    }
}
