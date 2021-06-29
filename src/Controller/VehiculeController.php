<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VehiculeController extends AbstractController
{
    #[Route('/vehicule/index', name: 'vehicule')]
    public function index(): Response
    {
        //Methode 1 de redirection
        // $url = $this->generateUrl('priorite');
        // return new RedirectResponse($url);

        //Methode 2 de redirection
        return $this-> redirectToRoute('priorite', []);
    }

    #[Route('/vehicule/{nom?}', name: 'vehicule_notFound')]
    public function notFound(?string $nom): Response
    {
        if(!isset($nom)){
            throw $this->createNotFoundException('Not found - sorry girl');
        }
        //Sinon
        return $this->render("vehicule/index.html.twig",[
            'controller_name' => 'VehiculeController',
        ]);
    }

    #[Route('/vehicule/json', name: 'vehicule_json')]
    public function vehiculeJSON(): Response
    {
        $tab = ["marque" => "BMW",
                "couleur" => "rouge"
        ];
        //Renvoie réponse au format JSON
        return $this->json($tab);
    }
}
