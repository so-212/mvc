<?php
namespace App\Controllers;

class AdminController extends Controller
{
    
   public function index()
    {
      
        //on vérifie si on est admin
       if($this->isAdmin()){

        $this->render('admin/index', [], 'admin');
            
       }  
    }
    
    /**
     * annonces affiche liste des annonces sous forme de tableau
     *
     * @return void
     */
    public function annonces()
    {
         
    }
    
    /**
     * isAdmin verifie si on est admin
     *
     * @return void
     */
    private function isAdmin(){
        ob_start();
        //on verifie si on est connecté et si role admin est ds nos role
        if(isset($_SESSION['user']) && in_array('ROLE_ADMIN', $_SESSION['user']['roles'])){
            //on est admin 
            $content = ob_get_clean();
            echo $content;
            return true;
        }else{
            //on est pas admin
            $_SESSION['erreur'] = "Vous n'avez pas accès à cette zone";
            header('location: /');
            exit;
        }


    }


}