<?php

namespace App\lib;

class TestUser{
    private $montexte;
    private $monchiffre;
    private $madate;

    public function __construct($mon_texte = 'voici un texte',$mon_chiffre = 55,$ma_date=('22/08/2001') ) {
        $this->montexte = $mon_texte;
        $this->monchiffre = $mon_chiffre;
        $this->madate = $ma_date;
    }

    public function getMontexte(): ?string
    {
        return $this->montexte;
    }

    public function setMontexte(string $montexte): self
    {
        $this->montexte = $montexte;

        return $this;
    }

    public function getMonchiffre(): ?int
    {
        return $this->monchiffre;
    }

    public function setMonchiffre(int $monchiffre): self
    {
        $this->monchiffre = $monchiffre;

        return $this;
    }

    public function getMadate(): ?string
    {
        return $this->madate;
    }

    public function setMadate(string $madate): self
    {
        $this->madate = $madate;

        return $this;
    }
}
