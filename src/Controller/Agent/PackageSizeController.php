<?php

namespace App\Controller\Agent;

use App\Entity\PackageSize;
use App\Form\Agent\PackageSizeType;
use App\Repository\PackageSizeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Service\SchoolSessionStorage;
/** 
* @IsGranted("ROLE_AGENT")
 * @Route("/agent/package-size")
 */
class PackageSizeController extends AbstractController
{
    private $schoolSessionStorage;

    public function __construct(SchoolSessionStorage $schoolSessionStorage)
    {        
        $this->schoolSessionStorage = $schoolSessionStorage;
    }

    /**
     * @Route("/", name="agent_package_size_index", methods={"GET"})
     */
    public function index(PackageSizeRepository $packageSizeRepository): Response
    {
        
        $school = $this->schoolSessionStorage->getSelectedSchool();

        $packageSizes =  $packageSizeRepository->findBySchoolQueryBuilder($school)
        ->getQuery()->getResult();
        

        return $this->render('agent/package_size/index.html.twig', [
            'package_sizes' => $packageSizes,
            'school'=>$school,
        ]);
    }

    /**
     * @Route("/new", name="agent_package_size_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        
        $packageSize = new PackageSize();
        $form = $this->createForm(PackageSizeType::class, $packageSize);
        $form->handleRequest($request);
        $school = $this->schoolSessionStorage->getSelectedSchool();
         
        if(!$school) {
            $this->addFlash('warning','请在上方选择栏里选择所要管理的学校(校区)');
           return $this->redirectToRoute('agent_package_size_index');
        }
        

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $packageSize->setSchool($school);

            $entityManager->persist($packageSize);
            $entityManager->flush();

            return $this->redirectToRoute('agent_package_size_index');
        }

        return $this->render('agent/package_size/new.html.twig', [
            'package_size' => $packageSize,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="agent_package_size_show", methods={"GET"})
     */
    public function show(PackageSize $packageSize): Response
    {
        return $this->render('agent/package_size/show.html.twig', [
            'package_size' => $packageSize,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="agent_package_size_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PackageSize $packageSize): Response
    {
        $this->denyAccessUnlessGranted('edit',$packageSize);

        $form = $this->createForm(PackageSizeType::class, $packageSize);
        $form->handleRequest($request);       

   
        if ($form->isSubmitted() && $form->isValid() ) {             
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('agent_package_size_index');
        }
   
        return $this->render('agent/package_size/edit.html.twig', [
            'package_size' => $packageSize,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="agent_package_size_delete", methods={"DELETE"})
     */
    public function delete(Request $request, PackageSize $packageSize): Response
    {
        if ($this->isCsrfTokenValid('delete'.$packageSize->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($packageSize);
            $entityManager->flush();
        }

        return $this->redirectToRoute('agent_package_size_index');
    }
}
