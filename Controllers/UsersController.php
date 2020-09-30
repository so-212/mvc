<?php

namespace App\Controllers;

use App\Core\Form;
use App\Models\UsersModel;

class UsersController extends Controller
{    
    /**
     * login connexion des utilisateurs
     *
     * @return void
     */
    public function login(){
        
        //on verifie si formulaire complet

        if(Form::validate($_POST, ['email', 'password'])){

            //formulaire complet
            //on verifie correspondance en base

            $userModel = new UsersModel;

            $userArray = $userModel->findOneByEmail(strip_tags($_POST['email']));
            
            //si utilisateur n'existe pas
            if(!$userArray){

                

                //envoie d'un message de session 
                $_SESSION['erreur'] = 'l\'adresse mail et ou mdp est incorrect';
                header('Location: /users/login');
                exit();

            }
            //l'utilisateur existe

             $user = $userModel->hydrate($userArray);

            //on verifie si mdp correct

            if(password_verify($_POST['password'], $user->getPassword())){

                //le mdp est le bon 
               

                $user->setSession();
                header('location: /');
                exit;


            }else{

                
                // var_dump($user);
                $_SESSION['erreur'] = 'l\'adresse mail et ou mdp est incorrect';
                header('Location: /users/login');
                exit();

            }

        }
        
        $form = new Form;

        $form->debutForm()
            ->ajoutLabelFor('email','E-mail :')
            ->ajoutInput('email', 'email', ['class' => 'form-control', 'id'
            => 'email'])
            ->ajoutLabelFor('pass', 'mot de passe : ')
            ->ajoutInput('password', 'password', ['id'=> 'pass', 'class' =>'form-control'])
            ->ajoutBouton('Me connecter', ['class' => 'btn btn-primary'])
            ->finForm();

        $this->render('users/login', ['loginForm' => $form->create()]);

    }
    
    /**
     * logout deconnecte utilisateur
     *
     * @return void
     */
    public function logout()
    {
        unset($_SESSION['user']);
        header('location: '. $_SERVER['HTTP_REFERER']);
        exit;

    }
    
    /**
     * register inscription des utilisateur
     *
     * @return void
     */
    public function register()
    {
        //verifiaction formulaire valide
        if(Form::validate($_POST, ['email', 'password']))
        {
            //leformulaire est valide,
            // on nettoie les user input
            $email = strip_tags($_POST['email']);
            //chiffrement mdp
            $pass = password_hash($_POST['password'], PASSWORD_ARGON2I);
            
            //on hydrate utilisateur en bdd

            $user = new UsersModel;
            $user->setEmail($email)
            ->setPass($pass);

            //stockage utilisateur

            $user->createBis();
        
        }

        $form = new Form;

        $form->debutForm()
        ->ajoutLabelFor('email', 'E-mail :')
        ->ajoutInput('email', 'email', ['id' => 'email', 'class' => 'form-control'] )
        ->ajoutLabelFor('pass', 'Mot de passe')
        ->ajoutInput('password', 'password', ['id' => 'pass ', 'class' => 'form-control'] )
        ->ajoutBouton('M inscrire', ['class' => 'btn btn-primary']  )
        ->finForm()
        ;

        $this->render('users/register',['registerForm' => $form->create()]);




    }

}