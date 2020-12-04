<?php

namespace App\Controller;

use App\Entity\Convocations;
use App\Form\ConvocationsType;
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
        ]);
    }

    /**
     * @Route("/{id}", name="convocations_show", methods={"GET"})
     */
    public function show(Convocations $convocation): Response
    {
        return $this->render('convocations/show.html.twig', [
            'convocation' => $convocation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="convocations_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Convocations $convocation): Response
    {
        $form = $this->createForm(ConvocationsType::class, $convocation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('convocations_index');
        }

        return $this->render('convocations/edit.html.twig', [
            'convocation' => $convocation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="convocations_delete", methods={"DELETE"})
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
