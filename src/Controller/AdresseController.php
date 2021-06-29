<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AdresseController extends AbstractController
{
    #[Route('/{adresse}', name: 'adresse')]
    public function index(Request $request): Response
    {
        //Récuperer données passée dans la route
        $adresse = $request->attributes->get("adresse");
        //Récuperer numéro passée au routes (dans url)
        //Parametre de substitution / path string
        $numero =  $request->query->get("numero");//$_GET["numero"]
        $codePostal =  $request->query->get("codePostal");
        return $this->render('adresse/index.html.twig', [
            'controller_name' => 'AdresseController',
            'method_name' => 'index',
            'adresse' => $adresse, //ne pas oublier afficher var dans index.html.twig
            'numero' => $numero,
            'code' => $codePostal,
        ]);
    }

    #[Route('/priorite', name: 'priorite')]
    public function priorite(): Response
    {
        return $this->render('adresse/index.html.twig', [
            'controller_name' => 'AdresseController',
            'method_name' => 'priorite',
            'adresse' => '', //ne pas oublier afficher var dans index.html.twig
            'numero' => '',
            'code' =>'',
        ]);
    }
}
