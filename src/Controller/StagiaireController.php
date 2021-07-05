<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Stagiaire;
use App\Repository\StagiaireRepository;
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
        $repo = $this->getDoctrine()->getRepository(Stagiaire::class);
        $stagiaires = $repo->findAll();//récupere toutes les données de la table (Select * from Table) -retourne une collection
        $count = $repo->countStagiaire();
        $nbTotalPage = ceil($count/5);
        return $this->render('stagiaire/index.html.twig', [
            'controller_name' => 'Liste des Stagiaires',
            'stagiaires' => $stagiaires,
            'pageCourante'=>1,
            'nbPage'=>5,
            'nbTotalPage'=> $nbTotalPage,
        ]);
    }

    #[Route('/creer', name: 'stagiaire_creer', methods : ['GET','POST'])]
    public function creer(): Response
    {
        $stagiaire = new Stagiaire();//créer un objet de type stagaire  
        $stagiaire->setNom('Knowles');
        $stagiaire->setPrenom('Beyoncé');

        $adresse = new Adresse();
        $adresse->setAdresse("Avenue des nuages");
        $adresse->setCodepostal("01010");
        $adresse->setVille("Olympe-sur-terre");

        $stagiaire->setAdresse($adresse);
        //récuperer le gestionnaire des entité (Entity Manager)
        //on crée une varibable que l'on appelle genéralement $em
        $entityManager = $this->getDoctrine()->getManager();
        //Appel de la méthode persist dans lequel on passe en argument l'objet que l'on souhaite persisté (enregistrer)
        //$entityManager->persist($adresse);
        $entityManager->persist($stagiaire);
        //Appel de la méthode flush - exécution d'une requête pour persister toutes nos commandes -> exécuter insert dans BDD (on l'appel une seule fois)
        $entityManager->flush();
        //Redirection vers la liste des stagiaire 
        return $this->redirectToRoute("stagiaire_liste");
    }

    #[Route('/{id<\d+>}', name:'stagiaire_afficher', methods:['GET'])]
    public function afficherStagiaire(int $id):Response { //récupére l'identifiant
        $repo = $this->getDoctrine()->getRepository(Stagiaire::class);
        $stagiaire = $repo->find($id); //récupére stagiaire par ID
        if(!$stagiaire){//si stagiaire n'existe pas , on léve une exception
            throw $this->createNotFoundException("Stagiaire non trouvé !");
        }
        return $this->render("stagiaire/afficher.html.twig",[
            "stagiaire"=>$stagiaire,
        ]);
    }

    #[Route('/{nom}/{prenom}', name:'stagiaire_afficher_par_nom_prenom', methods:['GET'])]
    public function afficherStagiaireParPatronyme(string $nom, string $prenom):Response { //récupére l'identifiant
        $repo = $this->getDoctrine()->getRepository(Stagiaire::class);
        $stagiaire = $repo->findOneBy([//récupére stagiaire par nom et prénom
            "nom"=>$nom,
            "prenom"=>$prenom
        ]); 
        if(!$stagiaire){//si stagiaire n'existe pas , on léve une exception
            throw $this->createNotFoundException("Stagiaire non trouvé !");
        }
        return $this->render("stagiaire/afficher.html.twig",[
            "stagiaire"=>$stagiaire,
        ]);
    }
    
    #[Route('/{nom}/{prenom}/{nombre}', name:'stagiaire_afficher_par_nom_prenom_nombre', methods:['GET'])]
    public function afficherNombreStagiaireParPatronyme(string $nom, string $prenom, int $nombre):Response { //récupére l'identifiant
        $repo = $this->getDoctrine()->getRepository(Stagiaire::class);
        $stagiaires = $repo->findBy( // prend 4 arguments
            ["nom"=>$nom,
            "prenom"=>$prenom
        ], // WHERE
            ["id"=> "ASC"], // ORDER BY
            $nombre, //LIMIT
            0 // commence au premier résultat
        ); 
        if(!$stagiaires || count($stagiaires) === 0 ){//vérifier si stagiaire est undefined/null , on léve une exception en affichant page 404
            throw $this->createNotFoundException("Stagiaire non trouvé !");
        }
        return $this->render('stagiaire/index.html.twig', [
            'stagiaires' => $stagiaires,
        ]);
    }

    #[Route('/liste/{page}/{nbPage}', name:'stagiaire_liste_pagination', methods:['GET'], priority:2)]
    public function listePagination(int $page, int $nbPage):Response { //récupére l'identifiant
        $repo = $this->getDoctrine()->getRepository(Stagiaire::class);
        $offset = ($page-1) * $nbPage;
        $stagiaires = $repo->findBy( // prend 4 arguments
            [], // tab vide = récupére tous les stagiaires
            ["id"=> "ASC"], // ORDER BY
            $nbPage, //correspond à nbr element par page - LIMIT
            $offset// offset - calcul par rapport au nbr page
        ); 
        if(!$stagiaires || count($stagiaires) === 0 ){//vérifier si stagiaire est undefined/null , on léve une exception en affichant page 404
            throw $this->createNotFoundException("Stagiaire non trouvé !");
        }

        //CODE PROVISOIRE
        //Requêter pour récupérer le nb total de stagiaire
        // $tousStagiares = $repo->findAll();
        // $nbStagiaires = count($tousStagiares);
        $nbStagiaires = $repo->countStagiaire();

        $nbTotalPage = ceil($nbStagiaires/$nbPage);
        return $this->render('stagiaire/index.html.twig', [
            'stagiaires' => $stagiaires,
            'nbTotalPage' => $nbTotalPage,
            'pageCourante' => $page,
            'nbPage' => $nbPage, //permet de génere l'URL
        ]);
    }
}
