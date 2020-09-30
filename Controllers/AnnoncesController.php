<?php
namespace App\Controllers;

use App\Core\Form;
use App\Models\AnnoncesModel;

class AnnoncesController extends Controller
{
    public function index(){

       //instanciation du model correspondant a table annonce
       $annoncesModel = new AnnoncesModel;
       //on va chercher tte les annonces actives
      $annonces =  $annoncesModel->findAll();

      $this->render('annonces/index', compact('annonces'));
        //['annonces' => $annonces] equivaut à compact('annonces')
        //La fonction compact() est une fonction intégrée en PHP et elle est utilisée pour créer un
        //tableau à l’aide de variables. Cette fonction fait l’inverse de la fonction extract(). 
        //Il crée un tableau associatif dont les clés 
        //sont des noms de variables et leurs valeurs correspondantes sont des valeurs de tableau.

    }

    //toujours le meme principe:
    //je cree une methode selon mon besoin qui instanci un modele, appelle 
//une methode du modele et la rend ds la vue ac la methode render
    
    /**
     * lire affiche une annonce
     *
     * @param  int $id
     * @return void
     */
    public function lire(int $id){

        //instancie le modele

        $annoncesModel = new AnnoncesModel;

        $annonce = $annoncesModel->findById($id);

        //envoie à la vue

        $this->render('annonces/lire', compact('annonce'));

       

    }
    
    /**
     * modifier une annonce
     *
     * @param  mixed $id
     * @return void
     */
    public function modifier(int $id)
    {

        //il faut etre un utilisateur connecter 
        if(isset($_SESSION['user']) && !empty($_SESSION['user']['id']))
        {
                //verification si annonce existe ds la base
                //on instancie le modele
                $annoncesModel = new AnnoncesModel;
               
                //on va chercher l annonce grace à l'id
                
                $annonce = $annoncesModel->findById($id);

                //si annonce n'existe pas, on retourne à liste annonces
                if(!$annonce)
                {
                    http_response_code(404);
                    $_SESSION['erreur'] = "l'annonce recherchée n'existe pas";
                    header('location: /annonces');
                    exit;

                }

                //verification si utilisateur proprietaire de l'annonce

                if($annonce->users_id !== $_SESSION['user']['id'])
                {
                    $_SESSION['erreur'] = "vous n'avez pas acces à cette page";
                    header('location: /annonces');
                    exit;
                }

                //formulaire de modifiaction apres les controle ci dessus
                //traitment du formulaire avant creation du formulaire contre injection

                if(Form::validate($_POST, ['titre', 'description'])){

                    //protection xss

                    $titre = strip_tags($_POST['titre']);
                    $description = strip_tags($_POST['description']);

                    //on stock l'annonce

                    $annonceModif = new AnnoncesModel ;
                    //hydratation du model

                    $annonceModif->setId($annonce->id)
                    ->setTitre($titre)
                    ->setDescription($description)
                    ;

                    //mise a jour de l'annonce

                    $annonceModif->update();

                    $_SESSION['message'] = 'votre annonce a été modifiée avec succes';
                    header('location: /');
                    exit;

                }



                $form = new Form;

                $form->debutForm()
                ->ajoutLabelFor('titre', 'Titre de l\'annonce :')
                ->ajoutInput('Text', 'titre', [
                    'id' => 'titre',
                    'class' => 'form-control',
                    'value' => $annonce->titre
                    ])
                ->ajoutLabelFor('description', 'Texte de l\'annonce :')
                ->ajoutTextArea('description', $annonce->description, [
                    'id' => 'description',
                     'class' => 'form-control'
                     ])
                ->ajoutBouton('modifier', ['class' => 'btn btn-primary'])
                ->finForm()            
                ;

                //envoi à la vue

                $this->render('annonces/modifier', ['form' => $form->create()]);
    





        }else{

                //utilisateur nn connecté
                $_SESSION['erreur'] = 'vous devez etre connecter pr acceder a cette page';
                header('Location: /users/login');
                exit;

            }

    }
    
    /**
     * ajouter une annonce
     *
     * @return void
     */
    public function ajouter()
    {
        //il faut etre un utilisateur connecter 
        if(isset($_SESSION['user']) && !empty($_SESSION['user']['id']))
        {

            //on vérifie que le formulaire est complet
            if(Form::validate($_POST, ['titre', 'description']))
            {
                //le formulaire est complet
                //protection contre failles XSS
                $titre =strip_tags($_POST['titre']);
                $description =  strip_tags($_POST['description']);

                //on instancie notre model
                $annonce = new AnnoncesModel;

                //on hydrate
                $annonce->setTitre($titre)
                ->setDescription($description)
                ->setUsers_id($_SESSION['user']['id']);

                //on enregistre

                $annonce->createBis();

                //on redirige ac message de session

                $_SESSION['message'] = 'votre annonce a été enregistrée avec succes';
                header('Location: /');
                exit;



            }else{
                //formulaire incomplet 
                $_SESSION['erreur'] = !empty($_POST) ? "Le formulaire est incomplet" : '';
                $titre = isset($_POST['titre']) ? strip_tags($_POST['titre']) : '';
                $description = isset($_POST['description']) ? strip_tags($_POST['description']) : '';
            }

            
            //utilisateur connectée
          

            $form = new Form;

            $form->debutForm()
            ->ajoutLabelFor('titre', 'Titre de l\'annonce :')
            ->ajoutInput('Text', 'titre', ['id' => 'titre', 'class' => 'form-control', 'value' => $titre])
            ->ajoutLabelFor('description', 'Texte de l\'annonce :')
            ->ajoutTextArea('description', $description, ['id' => 'description', 'class' => 'form-control'])
            ->ajoutBouton('Ajouter', ['class' => 'btn btn-primary'])
            ->finForm()            
            ;

            $this->render('annonces/ajouter', ['form' => $form->create()]);

        }else{

            //utilisateur nn connecté
            $_SESSION['erreur'] = 'vous devez etre connecter pr acceder a cette page';
            header('Location: /users/login');
            exit;
        }

    }

}