<?php

namespace App\Controller;

use App\Entity\Stagiaire;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/stagiaire')]
class StagiaireController extends AbstractController
{
    #[Route('/liste', name: 'stagiaire_liste', methods : ['GET'])]
    public function index(): Response
    {
        //Récupérer le repository pour la lecture - indiquer le nom de la classe dans la méthode getRepository
        $repo = $this->getDoctrine()->getRepository('Stagiare::class');
        $stagiaires = $repo->findAll();//récupere toutes les données de la table (Select * from Table) -retourne une collection
        return $this->render('stagiaire/index.html.twig', [
            'controller_name' => 'Liste des Stagiaires',
            'stagiaires' => $stagiaires,
        ]);
    }

    #[Route('/creer', name: 'stagiaire_creer', methods : ['GET','POST'])]
    public function creer(): Response
    {
        $stagiaire = new Stagiaire();
        $stagiaire->setNom('ANTON MARTIN DE PORRES');
        $stagiaire->setPrenom('Jérôme');
        //récuperer le gestionnaire des entité (Entity Manager)
        //on crée une varibable que l'on appelle genéralement $em
        $entityManager = $this->getDoctrine()->getManager();
        //Appel de la méthode persist dans lequel on passe en argument l'objet que l'on souhaite persisté (enregistrer)
        $entityManager->persist($stagiaire);
        //Appel de la méthode flush - exécution d'une requête pour persister toutes nos commandes -> exécuter insert dans BDD (on l'appel une seule fois)
        $entityManager->flush();
        //Redirection vers la liste des stagiaire 
        return $this->redirectToRoute("stagiaire_liste");
    }
}
