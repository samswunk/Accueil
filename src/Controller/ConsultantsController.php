<?php

namespace App\Controller;

use App\Entity\Consultants;
use App\Form\ConsultantsType;
use App\Repository\ConsultantsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/consultants")
 */
class ConsultantsController extends AbstractController
{
    // /**
    //  * @Route("/", name="consultants_index", methods={"GET"})
    //  */
    // public function index(ConsultantsRepository $consultantsRepository): Response
    // {
    //     return $this->render('consultants/index.html.twig', [
    //         'consultants' => $consultantsRepository->findAll(),
    //     ]);
    // }

    /**
     * @Route("/", name="consultants_index", methods={"GET"})
     */
    public function index(ConsultantsRepository $consultantsRepository): Response
    {
        return $this->render('consultants/index.html.twig', [
            'consultants' => $consultantsRepository->findAllBySql(),
        ]);
    }

    /**
     * @Route("/new", name="consultants_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $consultant = new Consultants();
        $form = $this->createForm(ConsultantsType::class, $consultant);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($consultant);
            $entityManager->flush();

            return $this->redirectToRoute('consultants_index');
        }

        return $this->render('consultants/new.html.twig', [
            'consultant' => $consultant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="consultants_show", methods={"GET"})
     */
    public function show(Consultants $consultant): Response
    {
        return $this->render('consultants/show.html.twig', [
            'consultant' => $consultant,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="consultants_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Consultants $consultant): Response
    {
        
        $form = $this->createForm(ConsultantsType::class, $consultant);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            
            return $this->redirectToRoute('consultants_index');
        }
        // dd($consultant);
        return $this->render('consultants/edit.html.twig', [
            'consultant' => $consultant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="consultants_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Consultants $consultant): Response
    {
        if ($this->isCsrfTokenValid('delete'.$consultant->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($consultant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('consultants_index');
    }
}
