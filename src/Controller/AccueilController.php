<?php

namespace App\Controller;

use App\Repository\ConsultantsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(ConsultantsRepository $consultantsRepository): Response
    {
        return $this->render('consultants/index.html.twig', [
            'consultants' => $consultantsRepository->findAllBySql(),
        ]);
    }
}
