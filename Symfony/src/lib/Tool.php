<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Tool{
    //Properties
    private $libelle;
    private $value;
    private $nb;

    //Constructor
    public function __construct($libelle='libelle',$value='value',$nb=0){
        $this->libelle=$libelle;
        $this->value=$value;
        $this->nb=$nb;
    }

    //Getters
    public function getLibelle(){
        return $this->libelle;
    }
    public function getValue(){
        return $this->value;
    }
    public function getNb(){
        return $this->nb;
    }
}

?>
