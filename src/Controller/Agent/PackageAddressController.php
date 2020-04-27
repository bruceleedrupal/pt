<?php

namespace App\Controller\Agent;

use App\Entity\PackageAddress;
use App\Form\Agent\PackageAddressType;
use App\Repository\PackageAddressRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Service\SchoolSessionStorage;
/** 
* @IsGranted("ROLE_AGENT")
 * @Route("/agent/package-address")
 */
class PackageAddressController extends AbstractController
{
    private $schoolSessionStorage;

    public function __construct(SchoolSessionStorage $schoolSessionStorage)
    {        
        $this->schoolSessionStorage = $schoolSessionStorage;
    }

    /**
     * @Route("/", name="agent_package_address_index", methods={"GET"})
     */
    public function index(PackageAddressRepository $packageAddressRepository): Response
    {
        
        $school = $this->schoolSessionStorage->getSelectedSchool();

        $packageAddresses =  $packageAddressRepository->findBySchoolQueryBuilder($school)
        ->getQuery()->getResult();
        

        return $this->render('agent/package_address/index.html.twig', [
            'package_addresses' => $packageAddresses,
            'school'=>$school,
        ]);
    }

    /**
     * @Route("/new", name="agent_package_address_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        
        $packageAddress = new PackageAddress();
        $form = $this->createForm(PackageAddressType::class, $packageAddress);
        $form->handleRequest($request);
        $school = $this->schoolSessionStorage->getSelectedSchool();
         
        if(!$school) {
            $this->addFlash('warning','请在上方选择栏里选择所要管理的学校(校区)');
           return $this->redirectToRoute('agent_package_address_index');
        }
        

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $packageAddress->setSchool($school);

            $entityManager->persist($packageAddress);
            $entityManager->flush();

            return $this->redirectToRoute('agent_package_address_index');
        }

        return $this->render('agent/package_address/new.html.twig', [
            'package_address' => $packageAddress,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="agent_package_address_show", methods={"GET"})
     */
    public function show(PackageAddress $packageAddress): Response
    {
        return $this->render('agent/package_address/show.html.twig', [
            'package_address' => $packageAddress,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="agent_package_address_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PackageAddress $packageAddress): Response
    {
        $this->denyAccessUnlessGranted('edit',$packageAddress);

        $form = $this->createForm(PackageAddressType::class, $packageAddress);
        $form->handleRequest($request);       

   
        if ($form->isSubmitted() && $form->isValid() ) {             
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('agent_package_address_index');
        }
   
        return $this->render('agent/package_address/edit.html.twig', [
            'package_address' => $packageAddress,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="agent_package_address_delete", methods={"DELETE"})
     */
    public function delete(Request $request, PackageAddress $packageAddress): Response
    {
        if ($this->isCsrfTokenValid('delete'.$packageAddress->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($packageAddress);
            $entityManager->flush();
        }

        return $this->redirectToRoute('agent_package_address_index');
    }
}
