<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'test')]
    public function index(Request $request): Response
    {
        // echo $request->getPathInfo();
        // echo $request->query->get('info');
        // echo "<pre>";
        // print_r($request->query->all());
        // echo "</pre>";
        // return $this->render('test/index.html.twig', [
        //     'controller_name' => 'TestController',
        // ]);
        // $response = new Response('Bienvenue dans Symfony');
        // return $response;

        /**Redirection avec variable de session */
        // $session = $request->getSession(); //session_start();
        // $maVariable = $session->set('userName','Shirley');
        // Redirection vers redirection();
        // $url=$this->generateUrl('redirection');
        // return $this->redirect($url);

        $session = $request->getSession();
        $session->getFlashBag()->add('info','Premier Message');
        $session->getFlashBag()->add('info','Deuxiéme Message');
        // Rediriger vers redirection();
        $url=$this->generateUrl('redirection');
        return $this->redirect($url);
    }

    /**Redirection -> affichage de la valeur de la variable de session */
    #[Route('/redirection', name: 'redirection')]
    public function redirection(Request $request): Response{
        //Redirection avec variable de session
        $session = $request->getSession();//session_start();
        // $maVariable=$session->get('userName');
        // $response = new Response($maVariable);
        // return $response;


        //Redirection avec flashbag
        $string = "";
        $maVariable=$session->getFlashBag()->get('info');
        foreach($maVariable as $key => $value){
            $string .= $key. " - ". $value . "<br/>";
        }

        $response = new Response($string);
        return $response;
    }
    

    #[Route('/test2', name: 'test2')]
    public function testing(Request $request): Response{
        $param = $request->query->all();

        $string = "";
        echo '<p>Les paramétres sont :</p>';
        foreach($param as $key => $value){
            $string .= '<ul>'. $key .' - ' . $value .'</ul>';
            // echo $string;
        }

        $response = new Response($string);
        return $response;
    }

    #[Route('/hello/{nom}/{prenom}/{age}', name: 'hello', requirements:["nom"=>"[a-z]{2,50}"])]
    public function hello(Request $request,$nom, $prenom, int $age): Response{
        $response = new Response('<h1> Hello ' . $prenom . ' ' . $nom . '</h1><br/><h2>Age = '.$age . '</h2>');
        return $response;
    }

    #[Route('/home/{nom}', name: 'home',)]
    public function index1(Request $request,$nom): Response{
        $response = new Response('<h1> Bonjour ' . $nom .  '</h1>');
        return $response;
    }

    #[Route('/home/index', name: 'home_index', priority:2)] //par défault, priorité = 0 
    public function index2(Request $request): Response{
        $response = new Response('<h1> Bitch, Please !</h1>');
        return $response;
    }

    #[Route('/hello1/{nom?}/{prenom?}', name: 'hello1',)]
    public function helloGirl(Request $request,?string $nom, ?string $prenom): Response{
        if(isset($nom,$prenom)){
            $response = new Response('<h1> Hello ' . $prenom . ' ' . $nom . '</h1>');
        return $response;
        } else {
            // $this->createNotFoundException('Cette page ne peut être génerer.');
            throw new HttpException(404, 'Cette page ne peut être génerer');
        }
        
    }

    #[Route('/param', name: 'param')] //par défault, priorité = 0 
    public function paramDefined(Request $request): Response{
        $nom = $this -> getParameter('nom');
        return new Response($nom);
    }

}
