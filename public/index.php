<?php

use App\Autoloader;
use App\Core\Main;

define('ROOT', dirname(__DIR__) );
//= index.php = fichier d'entrée ds mon application qui a pour fonction d'
// appeller Main notre routeur
// echo ROOT;
 
require_once ROOT.'/Autoloader.php';

Autoloader::register();

//on instancie Main 

$app = new Main();

//on demarre l'application

$app->start();

