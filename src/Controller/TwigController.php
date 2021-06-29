<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TwigController extends AbstractController
{
    #[Route('/twig', name: 'twig',priority:1)]
    public function index(Request $request): Response
    {
        $tab = [2,3,9];
        $nom = $request->query->get("nom");
        $prenom = $request->query->get("prenom");
        return $this->render('twig/index.html.twig', [
            'controller_name' => 'TwigController',
            'nom' => $nom,
            'prenom' => $prenom,
            'tableau' => $tab,
        ]);
    }
}
