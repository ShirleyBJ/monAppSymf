<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route("/produit", priority:1)]
class ProduitController extends AbstractController
{
    /**
     *  Affichage de la liste des produits
     */
    #[Route('/', name: 'produit_liste', methods : ['GET'])]
    public function index(): Response
    {
        return $this->render('produit/index.html.twig', [
            'controller_name' => 'Liste des produits',
        ]);
    }

    /**
     *  Affichage un produit 
     */
    #[Route('/{id}', name:'afficher_produit', methods : ['GET'])]
    public function afficherProduit(int $id): Response
        {
            return $this->render('produit/index.html.twig', [
                'controller_name' => 'Afficher un produit',
            ]);
        }

    /**
     *  Créer un produit 
     */
    #[Route('/', name:'creer_produit', methods : ['POST'],priority:1)]
    public function creerProduit(): Response
        {
            return $this->render('produit/index.html.twig', [
                'controller_name' => 'Créer un produit',
            ]);
        }

    /**
     *  Modifier un produit 
     */
    #[Route('/', name:'modifier_produit', methods : ['PUT'])]
    public function modifierProduit(): Response
        {
            return $this->render('produit/index.html.twig', [
                'controller_name' => 'Modifier un produit',
            ]);
        }

    /**
     *  Supprimer un produit 
     */
    #[Route('/{id}', name:'supprimer_produit', methods : ['DELETE'], priority:1)]
    public function supprimerProduit(int $id): Response
        {
            return $this->render('produit/index.html.twig', [
                'controller_name' => 'Supprimer un produit',
            ]);
        }

}

