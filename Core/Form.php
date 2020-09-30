<?php
namespace App\Core;

class Form
{

    private  $formCode = ''; //stock le formulaire crée, initialisé à vide

    //getter specifique au formulaire
    
    /**
     * génère le formulaire html
     * 
     *
     * @return void
     */
    public function create(){

        return $this->formCode;

    }
    
    /**
     * validation du formulaire si tous les chps sont rempli
     *
     * @param  mixed $form = tableau issu du formulaire via $_post ou $_get
     * @param  mixed $champs = tableau des champs obligatoires 
     * @return void
     */
    public static function validate(array $form, array $champs)
    {
        //on parcour les chps du formuliare
        foreach($champs as $champ){

            //on verifie que les chps st prsts et nn vide
            if(!isset($form[$champ]) || empty($form[$champ]))
            {

                return false;

            } 
        }
        return true;
    }
    
    /**
     * ajoutAttributs = ajoute les attribut html envoyé ds chaque balise que l'on crée
     *
     * @param  mixed $attributs
     * @return string
     */
    private function ajoutAttributs(array $attributs): string
    {

        //initialisation chaine de caracteres

        $str = '';

        //liste des attributs dit 'courts' comme required, autofocus... par exemple 
        $courts = ['checked', 'disabled', 'readonly', 'multiple', 'novalidate'
                      ,'formnovalidate'];

        foreach($attributs as $attribut => $valeur){
            //si attribut court
            if(in_array($attributs, $courts) && $valeur == true){

                $str .= " $attribut";

            }else{
                //on ajoute attribut = 'valeur'
                $str.= " $attribut=\"$valeur\""; 
            }

        }

        return $str;
    }

    
    /**
     * debutForm = crée la balise d'ouverture form
     *
     * @param  mixed $methode du formulaire
     * @param  mixed $action
     * @return Form
     */
    public function debutForm(string $methode = 'post', string $action = '#', 
    array $attributs = []):self
    {
        //on crée la balise form
        $this->formCode .= "<form action='$action' method='$methode'";

        //on ajoute les attributs eventuels    
        
        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs).'>' : '>';
    
        return $this;
    }

    
    /**
     * findForm balise de fermeture du formulaire
     *
     * @return void
     */
    public function finForm()
    {
        $this->formCode .= '</form>';

        return $this;

    }

    public function ajoutLabelFor(string $for, string $texte,
     array $attributs = []): self
    {
        //on ouvre la balise

        $this->formCode .= "<label for='$for'";

        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs): '';

        //on ajoute le texte

        $this->formCode .= ">$texte</label>";



        return $this;
    }

    public function ajoutInput(string $type, string $nom, array $attributs = [])
    {

        //on ouvre la balise

        $this->formCode .= "<input type='$type' name='$nom'";
        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs).'>':'>';
        return $this;
    }

    public function ajoutTextArea(string $nom, string $valeur = '', array $attributs = []):self
    {

        //on ouvre la balise

        $this->formCode .= "><textarea name='$nom'";

        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs): '';

        //on ajoute le texte

        $this->formCode .= ">$valeur</textarea>";

        return $this;

    }

    public function ajoutSelect(string $nom, array $options, array $attributs = [])
    {

        //creation du select

        $this->formCode .= "<select name='$nom'>";
        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs).'>': '';
       
        foreach($options as $valeur => $texte){

            $this->formCode .= "<option value=\"$valeur\">$texte</option>";

        }

        $this->formCode .= "</select>";
        return $this;

    }

    public function ajoutBouton(string $texte, array $attributs = [])
    {
        $this->formCode .= "<button " ;
        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs): ' mt-3';
        $this->formCode .= ">$texte</button>";

        return $this;

    }


}