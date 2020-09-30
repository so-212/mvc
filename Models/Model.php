<?php

namespace App\Models;

use App\Core\Db;

class Model extends Db
{

    //table en base 

    protected $table;

    //instance de Db

    private $db; 


    public function findAll(){
        $sql = 'SELECT * FROM '.$this->table;
        $data = $this->requete($sql);
        return $data->fetchAll();
    }

    public function findBy(array $criteres = [])
    {
        $champs = [];
        $valeurs = [];

        foreach($criteres as $champ => $valeur){
            $champs[] = "$champ = ?";
            $valeurs[] = $valeur;
        }

       $liste_champs = implode(' AND ', $champs);

    //    echo $liste_champs;

        $sql = 'SELECT * FROM '.$this->table.' WHERE '.$liste_champs;

        return $this->requete($sql, $valeurs)->fetchAll();

    }

    public function findById(int $id)
    {

        $sql = ' SELECT * FROM '.$this->table.' WHERE id='. $id ; 
     
        return $this->requete($sql)->fetch();
    } 

    public function create(array $data)
    {
        $champs  = [];
        $valeurs = [];

        foreach($data as $champ => $valeur){
            $champs[]  = "$champ";
            $params[]  = "?";
            $valeurs[] = $valeur;
        }

        $liste_champs = implode(' ,', $champs);
        $liste_params = implode(' , ', $params);

        echo $liste_champs;
        echo $liste_params;
        // $sql = 'INSERT INTO '.$this->table.'('.$liste_champs.') VALUES '.'('.$liste_params.')';

        // return $this->requete($sql, $valeurs);


    }

    public function createBis()
    {

        $champs = [];
        $inter = [];
        $valeurs = [];

        foreach($this as $champ => $valeur){

            if(!empty($valeur) && $champ != 'db' && $champ != 'table'){
                $champs[]= $champ;
                $inter[] = "?";
                $valeurs[]= $valeur;
            }
           
        }

        unset($champ);

       $liste_champs = implode(', ', $champs);
       $liste_inter = implode(', ', $inter);

    //    echo $liste_champs;
    //    echo $liste_inter;

        return $this->requete('INSERT INTO '.$this->table.' (' . $liste_champs . ') VALUES 
        ('.$liste_inter.')'
        , $valeurs);

    }

    public function hydrate($data)
    {

        foreach($data as $key => $valeur){

            $setter = 'set'.ucfirst($key);
            if(method_exists($this, $setter)){
                $this->$setter($valeur);

            }
        }
        return $this;

    }

    public function update()
    {


        $champs = [];
        $valeurs = [];


        foreach($this as $champ => $valeur)
        {
            if($valeur !== null && $champ != 'db' && $champ != 'table'){
                $champs[]="$champ = ?";
                $valeurs[]=$valeur;
            }
           
        }
        $valeurs[]=$this->id;

        

        $liste_champs = implode(', ', $champs);

       

        $sql = ' UPDATE '.$this->table.' SET '.$liste_champs.' WHERE id=?';

    
        return $this->requete($sql, $valeurs);


    }

    public function delete(int $id)
    {

        $sql = 'DELETE FROM '.$this->table.' WHERE id= ?';

        return $this->requete($sql, [$id]);


    }




    //methode principale executant la requete
    protected function requete(string $sql, array $attributs = null)
    {
        $this->db = Db::getInstance();
        //si attributs la requete est préparée
        if(!empty($attributs)){

            $query = $this->db->prepare($sql);
            $query->execute($attributs);
            return $query;

        }else{
            return $this->db->query($sql);
        }
    }




}