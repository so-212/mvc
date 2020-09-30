<?php

namespace App\Models;

class UsersModel extends Model
{
    protected $id;
    protected $email;
    protected $pass;
   

    public function __construct()
    {
        $class = str_replace(__NAMESPACE__.'\\', '', __CLASS__);
        $this->table = strtolower(str_replace('Model', '', $class));
    }
    
    /**
     * findOneByEmail
     * 
     * recupere un user par son mail
     *
     * @param  mixed $email
     * @return void
     */
    public function findOneByEmail(string $email){

        return $this->requete('SELECT * FROM '.$this->table.' WHERE email = ?'
        , [$email])->fetch();

    }
    
    /**
     * setSession cree la session de l'utilisateur
     *
     * @return void
     */
    public function setSession()
    {
        $_SESSION['user'] = ['id' => $this->id, 'email' => $this->email];

    }




    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->pass;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPass($password)
    {
        $this->pass = $password;

        return $this;
    }

   
}