<?php

namespace App\Controller;

use App\Entity\TypeInvitation;
use App\Form\TypeInvitationType;
use App\Repository\TypeInvitationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/type/invitation")
 */
class TypeInvitationController extends AbstractController
{
    /**
     * @Route("/", name="type_invitation_index", methods={"GET"})
     */
    public function index(TypeInvitationRepository $typeInvitationRepository): Response
    {
        return $this->render('type_invitation/index.html.twig', [
            'type_invitations' => $typeInvitationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="type_invitation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $typeInvitation = new TypeInvitation();
        $form = $this->createForm(TypeInvitationType::class, $typeInvitation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($typeInvitation);
            $entityManager->flush();

            return $this->redirectToRoute('type_invitation_index');
        }

        return $this->render('type_invitation/new.html.twig', [
            'type_invitation' => $typeInvitation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type_invitation_show", methods={"GET"})
     */
    public function show(TypeInvitation $typeInvitation): Response
    {
        return $this->render('type_invitation/show.html.twig', [
            'type_invitation' => $typeInvitation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="type_invitation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TypeInvitation $typeInvitation): Response
    {
        $form = $this->createForm(TypeInvitationType::class, $typeInvitation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('type_invitation_index');
        }

        return $this->render('type_invitation/edit.html.twig', [
            'type_invitation' => $typeInvitation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type_invitation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, TypeInvitation $typeInvitation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeInvitation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($typeInvitation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('type_invitation_index');
    }
}
