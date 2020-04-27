<?php

namespace App\Controller\Agent;

use App\Entity\ReceiveAddress;
use App\Form\Agent\ReceiveAddressType;
use App\Repository\ReceiveAddressRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Service\SchoolSessionStorage;

/**
  * @IsGranted("ROLE_AGENT")
 * @Route("/agent/receive-address")
 */
class ReceiveAddressController extends AbstractController
{
    private $schoolSessionStorage;

    public function __construct(SchoolSessionStorage $schoolSessionStorage)
    {        
        $this->schoolSessionStorage = $schoolSessionStorage;
    }
   
   
    /**
     * @Route("/", name="agent_receive_address_index", methods={"GET"})
     */
   public function index(ReceiveAddressRepository $receiveAddressRepository): Response
    {
        $school = $this->schoolSessionStorage->getSelectedSchool();

        $receiveAddresses =  $receiveAddressRepository->findBySchoolQueryBuilder($school)
        ->getQuery()->getResult();

        return $this->render('agent/receive_address/index.html.twig', [
            'receive_addresses' => $receiveAddresses
        ]);
    }

    /**
     * @Route("/new", name="agent_receive_address_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $receiveAddress = new ReceiveAddress();
        $form = $this->createForm(ReceiveAddressType::class, $receiveAddress);
        $form->handleRequest($request);
        $school = $this->schoolSessionStorage->getSelectedSchool();
         
        if(!$school) {
            $this->addFlash('warning','请在上方选择栏里选择所要管理的学校(校区)');
           return $this->redirectToRoute('agent_package_address_index');
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $receiveAddress->setSchool($school);
            $entityManager->persist($receiveAddress);
            $entityManager->flush();
            return $this->redirectToRoute('agent_receive_address_index');
        }

        return $this->render('agent/receive_address/new.html.twig', [
            'receive_address' => $receiveAddress,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="agent_receive_address_show", methods={"GET"})
     */
    public function show(ReceiveAddress $receiveAddress): Response
    {
        return $this->render('agent/receive_address/show.html.twig', [
            'receive_address' => $receiveAddress,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="agent_receive_address_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ReceiveAddress $receiveAddress): Response
    {
        $form = $this->createForm(ReceiveAddressType::class, $receiveAddress);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('agent_receive_address_index');
        }

        return $this->render('agent/receive_address/edit.html.twig', [
            'receive_address' => $receiveAddress,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="agent_receive_address_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ReceiveAddress $receiveAddress): Response
    {
        if ($this->isCsrfTokenValid('delete'.$receiveAddress->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($receiveAddress);
            $entityManager->flush();
        }

        return $this->redirectToRoute('agent_receive_address_index');
    }
}
