<?php

namespace App\Controller;

use App\Entity\Consultants;
use App\Entity\Convocations;
use App\Form\ConvocationsType;
use App\Repository\ConsultantsRepository;
use App\Repository\ConvocationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/convocations")
 */
class ConvocationsController extends AbstractController
{
    /**
     * @Route("/", name="convocations_index", methods={"GET"})
     */
    public function index(ConvocationsRepository $convocationsRepository): Response
    {
        return $this->render('convocations/index.html.twig', [
            'convocations' => $convocationsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/detail/{idconvo}", name="convocations_detail", methods={"GET"})
     */
    public function convocationDetail(ConvocationsRepository $convocationsRepository,$idconvo): Response
    {
        $convo = $convocationsRepository->findAllBySqlBy($idconvo);
        $nbrconvo = $convocationsRepository->NbrPersConvoc($idconvo);
        
        return $this->render('convocations/detail.html.twig', [
            'convocations'   => $convo,
            'idconvo'       => $idconvo,
            'date'          => $convo[0]['dateconvocation'],
            'nbrconvo'    => $nbrconvo[0]['nbrpersconvoquees']
        ]);
    }

    /**
    * @Route("/invitnbrmax/{idconvo}/{ajout}", name="modif_nbrmax_convocation", methods={"GET"})
    */
    public function modifNbrmaxConvocation(ConvocationsRepository $convocationsRepository,$idconvo,$ajout): Response
    {
        $invi   = $convocationsRepository->find($idconvo);
        $entityManager = $this->getDoctrine()->getManager();
        
        // dd('id:', $id,'idconvo:',$idconvo,'consultant:',$consultant,'invi:',$invi);
        $nbrActuel=$invi->getNbrpersonnes();

        if($ajout) 
        {
            $invi->setNbrpersonnes($nbrActuel+1);
        }
        else 
        {
            if ($nbrActuel>0)
                {
                    $invi->setNbrpersonnes($nbrActuel-1);
                }
        }
        $entityManager->persist($invi);
        $entityManager->flush();
        
        $convo  = $convocationsRepository->findAllBySqlBy($idconvo);
        $nbrconvo = $convocationsRepository->NbrPersConvoc($idconvo);
        return $this->render('convocations/detail.html.twig', [
            'convocations'   => $convo,
            'idconvo'       => $idconvo,
            'date'          => $convo[0]['dateconvocation'],
            'nbrconvo'    => $nbrconvo[0]['nbrpersconvoquees']
        ]);
    }

    /**
    * @Route("/invit/{id}/{idconvo}/{convoquer}", name="convoquer_pers", methods={"GET"})
    */
    public function convoquerPersonne(ConvocationsRepository $convocationsRepository,$id,$idconvo,$convoquer): Response
    {
        $invi   = $convocationsRepository->find($idconvo);
        $entityManager = $this->getDoctrine()->getManager();
        
        $consultant = $this->getDoctrine()
        ->getRepository(Consultants::class, 'default')
        ->find($id);
        // dd('id:', $id,'idconvo:',$idconvo,'consultant:',$consultant,'invi:',$invi);
        
        if($convoquer) {
            $invi->setNti($consultant);
        }
        else {
            $invi->setNti(null);
        }
        $entityManager->persist($invi);
        $entityManager->flush();
        
        $convo  = $convocationsRepository->findAllBySqlBy($idconvo);
        $nbrconvo = $convocationsRepository->NbrPersConvoc($idconvo);
        
        return $this->render('convocations/detail.html.twig', [
            'convocations'   => $convo,
            'idconvo'       => $idconvo,
            'date'          => $convo[0]['dateconvocation'],
            'nbrconvo'    => $nbrconvo[0]['nbrpersconvoquees']
        ]);
    }

    /**
     * @Route("/new", name="convocations_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $convocation = new Convocations();
        $form = $this->createForm(ConvocationsType::class, $convocation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($convocation);
            $entityManager->flush();
            
            return $this->redirectToRoute('convocations_index');
        }

        return $this->render('convocations/new.html.twig', [
            'convocation' => $convocation,
            'form' => $form->createView(),
            'idconvo'=>$convocation->getId()
        ]);
    }

    /**
     * @Route("/{idconvo}", name="convocations_show", methods={"GET"})
     */
    public function show(Convocations $convocation): Response
    {
        return $this->render('convocations/show.html.twig', [
            'convocation'   => $convocation,
            'idconvo'       => $convocation->getId()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="convocations_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Convocations $convocation, ConvocationsRepository $convocationsRepository,$id): Response
    {
        $form = $this->createForm(ConvocationsType::class, $convocation);
        $form->handleRequest($request);
        $submittedToken = $request->request->get('token');
        // if ($this->isCsrfTokenValid('delete-item', $submittedToken)) {
            
        if ($form->isSubmitted() && ($form->isValid() || $this->isCsrfTokenValid('edit', $submittedToken))) {
        
            $this->getDoctrine()->getManager()->flush();
            
            if ($this->isCsrfTokenValid('edit', $submittedToken)) {
                $idconvo = $id;
                $convo  = $convocationsRepository->findAllBySqlBy($idconvo);
                $nbrconvo = $convocationsRepository->NbrPersConvoc($idconvo);
                // dd($convo,$idconvo,$submittedToken,$nbrconvo[0]['nbrpersconvoquees']);
                return $this->render('convocations/detail.html.twig', [
                    'convocations'   => $convo,
                    'idconvo'       => $idconvo,
                    'date'          => $convocation->getDateconvocation(),
                    'nbrconvo'      => $nbrconvo[0]['nbrpersconvoquees']
                ]);
            }
            else {
                return $this->redirectToRoute('convocations_index');
            }
        }

        return $this->render('convocations/edit.html.twig', [
            'convocation' => $convocation,
            'idconvo' => $convocation->getId(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idconvo}", name="convocations_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Convocations $convocation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$convocation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($convocation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('convocations_index');
    }
}
