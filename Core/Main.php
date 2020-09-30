<?php
namespace App\Core;

use App\Controllers\MainController;

class Main
{

    public function start()
    {
      //on demarre la session avant tte chose
      session_start();
      //mllm

      


         //http://MVC2/controleur/methode/parametres
        
        //en vrai: 
        //http://MVC2/index.php?p=controleur/methode/parametres

        // var_dump($_GET);

        //on retire le trailing slash eventuel
        //on recupere url

        $uri = $_SERVER['REQUEST_URI'];
        //on verifi uri n'est pas vide et trailingslash
        if(!empty($uri) && $uri != '/' && $uri[-1] == "/"){
            //retrait du trailling slash
            $uri = substr($uri, 0, -1);

            //code de redirection permanente
            http_response_code(301);
            header('location: '.$uri);

        }
        
        
        //gestion des parametres d'url
        //p=controleur/methode/parametre
        //separation des param ds un tableau

        $params = explode('/', $_GET['p']);
        // var_dump($params);

        if($params[0]){

            $controller = '\\App\\Controllers\\'.ucfirst(array_shift($params)).'Controller';

            // La fonction array_shift() est une fonction intégrée qui supprime le premier
            //  élément d’un tableau et renvoie la valeur d’un élément supprimé. Toutes les clés
            //   du tableau numérique seront modifiées pour remet le compteur à zéro tandis que les clés 
            //   de type chaîne 
            // ne seront pas modifiées. Si un tableau est vide, la valeur « Null » est renvoyé.

            $controller = new $controller();
            //on recupere le 2em para d'url
            $action = (isset($params[0]))? array_shift($params) : 'index';

            if(method_exists($controller, $action)){
                //s'il reste des params on les passe sous 
                //forme des tablo  à la methode
                (isset($params[0]))? call_user_func_array([$controller, $action],$params): $controller->$action(); 


            }else{
                http_response_code(404);
                echo 'la page recherchée n existe pas';
            }




        }else{
            //pas de parametre, instancie le controleur par defaut

            $controller = new MainController();
            $controller->index();

        }




    }

}
