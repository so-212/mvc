<?php
namespace App\Controllers;

abstract class Controller
{
    
    /**
     * render
     *
     * @param  mixed $fichier de la vue
     * @param  mixed $donnees donnes retournée par le modele 
     * @return void
     */
    public function render(string $fichier, array $donnees =[], string
     $template = 'default' )
    {
       
       //extraction des données du tableau $donnees chak clef devient une varibale
       //un tableau ici

       //La fonction extract() est une fonction intégrée en PHP. 
       //La fonction extract() effectue une conversion de tableau en variable.
       //C’est-à-dire qu’il convertit les clés de tableau
       //en noms de variable et les valeurs de tableau en valeur de variable.
       //Renvoie le nombre de variables extraites en cas de succès
       //Entrée : array("a" => "jean", "b" => "alex", "c" => "bob")
       // Sortie : $a = "jean" , $b = "alex" , $c = "bob"

        extract($donnees);


        // pr injecter le contenu ds le template on utilise un buffer de sortie
        // ob_start : on dit a php des qu'on t'envoie du html met le en memoire
        // ob_end : met le tout ds une varible = buffer de sortie    

        ob_start();
        //a partir de ce point ttze sortie html est conservée en mémoire
        //exemple : si je fais echo 'bonjour'; ici je px le recuperer ds 
        //$contenu = ob_get_clean()  (stock le buffer ds la varibale)
        //ici on recupere le buffer apres avoir chargé la vue

        //chemin vers la vue

        require_once ROOT.'/Views/'.$fichier.'.php';

        $contenu = ob_get_clean();


        require_once ROOT.'/Views/'.$template.'.php';


    }



}

