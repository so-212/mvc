<?php

namespace App\Core;

use PDO;
use PDOException;

class Db extends PDO
{

    private static $instance;

    private const DBHOST = 'localhost';
    private const DBUSER = 'two_one_two';
    private const DBPASS = '12';
    private const DBNAME = 'demo_poo';

    private  function __construct()
    {
        $_dsn = 'mysql:host='.self::DBHOST.';dbname='.self::DBNAME;

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_CASE => PDO::CASE_NATURAL,
            PDO::ATTR_ORACLE_NULLS => PDO::NULL_EMPTY_STRING,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ];

        //appel au constructeur de la classe PDO
        try{

            parent::__construct($_dsn, self::DBUSER, self::DBPASS, $options);

        }catch(PDOException $e){

            die($e->getMessage());

        }
    }


    public static function getInstance(): self{

        if(self::$instance === null){
            self::$instance = new self();
        }

        return self::$instance;


    }






}