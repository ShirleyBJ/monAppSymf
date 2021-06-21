<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
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


        $session = $request->getSession(); //session_start();
        $maVariable = $session->set('userName','Shirley');
        //Redirection vers redirection();
        $url=$this->generateUrl('redirection');
        return $this->redirect($url);
    }

    /**Redirection -> affichage de la valeur de la variable de session */
    #[Route('/redirection', name: 'redirection')]
    public function redirection(Request $request): Response{
        //Ne pas oublier de redémarrer la session
        $session = $request->getSession();//session_start();
        $maVariable=$session->get('userName');

        $response = new Response($maVariable);
        return $response;
    }
    

    #[Route('/test2', name: 'test2')]
    public function hello(Request $request): Response{
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

}
