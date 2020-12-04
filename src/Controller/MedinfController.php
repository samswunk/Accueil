<?php

namespace App\Controller;

use App\Entity\Medinf;
use App\Form\MedinfType;
use App\Repository\MedinfRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/medinf")
 */
class MedinfController extends AbstractController
{
    /**
     * @Route("/", name="medinf_index", methods={"GET"})
     */
    public function index(MedinfRepository $medinfRepository): Response
    {
        return $this->render('medinf/index.html.twig', [
            'medinfs' => $medinfRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="medinf_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $medinf = new Medinf();
        $form = $this->createForm(MedinfType::class, $medinf);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($medinf);
            $entityManager->flush();

            return $this->redirectToRoute('medinf_index');
        }

        return $this->render('medinf/new.html.twig', [
            'medinf' => $medinf,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="medinf_show", methods={"GET"})
     */
    public function show(Medinf $medinf): Response
    {
        return $this->render('medinf/show.html.twig', [
            'medinf' => $medinf,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="medinf_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Medinf $medinf): Response
    {
        $form = $this->createForm(MedinfType::class, $medinf);
        $form->handleRequest($request);
        dd($medinf);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('medinf_index');
        }

        return $this->render('medinf/edit.html.twig', [
            'medinf' => $medinf,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="medinf_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Medinf $medinf): Response
    {
        if ($this->isCsrfTokenValid('delete'.$medinf->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($medinf);
            $entityManager->flush();
        }

        return $this->redirectToRoute('medinf_index');
    }
}
