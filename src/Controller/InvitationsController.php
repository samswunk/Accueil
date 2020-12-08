<?php

namespace App\Controller;

use App\Entity\Consultants;
use App\Entity\Invitations;
use App\Form\InvitationsType;
use App\Repository\ConsultantsRepository;
use App\Repository\InvitationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/invitations")
 */
class InvitationsController extends AbstractController
{
    /**
     * @Route("/", name="invitations_index", methods={"GET"})
     */
    public function index(InvitationsRepository $invitationsRepository): Response
    {
        return $this->render('invitations/index.html.twig', [
            'invitations' => $invitationsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/detail/{invitid}", name="invitations_detail", methods={"GET"})
     */
    public function invitationDetail(InvitationsRepository $invitationsRepository,$invitid): Response
    {
        $invit = $invitationsRepository->findAllBySqlBy($invitid);
        $nbrinvites = $invitationsRepository->NbrPersInvit($invitid);
        
        return $this->render('invitations/detail.html.twig', [
            'invitations'   => $invit,
            'invitid'       => $invitid,
            'date'          => $invit[0]['dateinvitation'],
            'nbrinvites'    => $nbrinvites[0]['nbrpersinvites']
        ]);
    }

    /**
    * @Route("/invitnbrmax/{invitid}/{ajout}", name="modif_nbrmax_invitation", methods={"GET"})
    */
    public function modifNbrmaxInvitation(InvitationsRepository $invitationsRepository,$invitid,$ajout): Response
    {
        $invi   = $invitationsRepository->find($invitid);
        $entityManager = $this->getDoctrine()->getManager();
        
        // dd('id:', $id,'invitid:',$invitid,'consultant:',$consultant,'invi:',$invi);
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
        
        $invit  = $invitationsRepository->findAllBySqlBy($invitid);
        $nbrinvites = $invitationsRepository->NbrPersInvit($invitid);
        return $this->render('invitations/detail.html.twig', [
            'invitations'   => $invit,
            'invitid'       => $invitid,
            'date'          => $invit[0]['dateinvitation'],
            'nbrinvites'    => $nbrinvites[0]['nbrpersinvites']
        ]);
        /*return $this->render('invitations/detail.html.twig', [
            'invitations'   => $invit,
            'invitid'       => $invitid,
            'date'          => $invit[0]['dateinvitation'],
            'nbrinvites'    => $nbrinvites[0]['nbrpersinvites']
        ]);*/
    }

    /**
    * @Route("/invit/{id}/{invitid}/{inviter}", name="inviter_pers", methods={"GET"})
    */
    public function inviterPersonne(InvitationsRepository $invitationsRepository,$id,$invitid,$inviter): Response
    {
        $invi   = $invitationsRepository->find($invitid);
        $entityManager = $this->getDoctrine()->getManager();
        
        $consultant = $this->getDoctrine()
        ->getRepository(Consultants::class, 'default')
        ->find($id);
        // dd('id:', $id,'invitid:',$invitid,'consultant:',$consultant,'invi:',$invi);
        
        if($inviter) {
            $consultant->addInvitation($invi);
        }
        else {
            $consultant->removeInvitation($invi);
        }
        $entityManager->persist($consultant);
        $entityManager->flush();
        
        $invit  = $invitationsRepository->findAllBySqlBy($invitid);
        $nbrinvites = $invitationsRepository->NbrPersInvit($invitid);
        
        return $this->render('invitations/detail.html.twig', [
            'invitations'   => $invit,
            'invitid'       => $invitid,
            'date'          => $invit[0]['dateinvitation'],
            'nbrinvites'    => $nbrinvites[0]['nbrpersinvites']
        ]);
        /*return $this->render('invitations/detail.html.twig', [
            'invitations'   => $invit,
            'invitid'       => $invitid,
            'date'          => $invit[0]['dateinvitation'],
            'nbrinvites'    => $nbrinvites[0]['nbrpersinvites']
        ]);*/
    }

    /**
    * @Route("/desinvit/{id}", name="desinviter_pers", methods={"GET"})
    */
    // public function desinviterPersonne(InvitationsRepository $invitationsRepository,$id): Response
    // {
    //     $invit = $invitationsRepository->findAllBySqlBy($id);
    //     $nbrinvites = $invitationsRepository->NbrPersInvit($id);

    //     return $this->redirectToRoute('invitations_detail', [
    //         'invitations'   => $invit,
    //         'invitid'       => $invitid,
    //         'date'          => $invit[0]['dateinvitation'],
    //         'nbrinvites'    => $nbrinvites[0]['nbrpersinvites']
    //     ]);
    //     /*return $this->render('invitations/detail.html.twig', [
    //         'invitations'   => $invit,
    //         'invitid'       => $id,
    //         'date'          => $invit[0]['dateinvitation'],
    //         'nbrinvites'    => $nbrinvites[0]['nbrpersinvites']
    //     ]);*/
    //     /*return $this->render('invitations/index.html.twig', [
    //         'invitations' => $invitationsRepository->findAll(),
    //     ]);*/
    // }


    /**
     * @Route("/new", name="invitations_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $invitation = new Invitations();
        $form = $this->createForm(InvitationsType::class, $invitation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($invitation);
            $entityManager->flush();

            return $this->redirectToRoute('invitations_index');
        }

        return $this->render('invitations/new.html.twig', [
            'invitation' => $invitation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="invitations_show", methods={"GET"})
     */
    public function show(Invitations $invitation): Response
    {
        return $this->render('invitations/show.html.twig', [
            'invitation' => $invitation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="invitations_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Invitations $invitation, InvitationsRepository $invitationsRepository,$id): Response
    {
        $form = $this->createForm(InvitationsType::class, $invitation);
        $form->handleRequest($request);
        $submittedToken = $request->request->get('token');
        // if ($this->isCsrfTokenValid('delete-item', $submittedToken)) {
            
        if ($form->isSubmitted() && ($form->isValid() || $this->isCsrfTokenValid('edit', $submittedToken))) {
        
            $this->getDoctrine()->getManager()->flush();
            
            if ($this->isCsrfTokenValid('edit', $submittedToken)) {
                $invitid = $id;
                $invit  = $invitationsRepository->findAllBySqlBy($invitid);
                $nbrinvites = $invitationsRepository->NbrPersInvit($invitid);
                // dd($request,$form->isValid(),$submittedToken,$this->isCsrfTokenValid('edit', $submittedToken));
                return $this->render('invitations/detail.html.twig', [
                    'invitations'   => $invit,
                    'invitid'       => $invitid,
                    'date'          => $invit[0]['dateinvitation'],
                    'nbrinvites'    => $nbrinvites[0]['nbrpersinvites']
                ]);
            }
            else {
                return $this->redirectToRoute('invitations_index');
            }
        }

        return $this->render('invitations/edit.html.twig', [
            'invitation' => $invitation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="invitations_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Invitations $invitation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$invitation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($invitation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('invitations_index');
    }
}
