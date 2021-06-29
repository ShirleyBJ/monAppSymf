<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Personne;
class TwigController extends AbstractController
{
    #[Route('/twig', name: 'twig',priority:1)]
    public function index(Request $request): Response
    {
        $tab = [2,3,8];
        //créer un objet de type personne
        $personne = new Personne();//instancie , créer un objet de type personne
        //Initialisation de l'objet personne qui est vide, on lui donne des valeurs
        $personne->setNom("Monroe");
        $personne->setPrenom("Marylin");
        $nom = $request->query->get("nom");
        $prenom = $request->query->get("prenom");
        return $this->render('twig/index.html.twig', [
            'controller_name' => 'TwigController',
            'nom' => $nom,
            'prenom' => $prenom,
            'tableau' => $tab,
            'personne' => $personne,
            'noms' => ["d'artagnan","athos","portos","aramis","zeus","poseidon","hadés"], 
            "js" => '<script>alert("XSS - Injection de code actif")</script>' ,  
        ]);
    }
}
