<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\EspeceRepository;


/**
 * Espece
 *
 * @ORM\Table(name="espece")
 * @ORM\Entity(repositoryClass=EspeceRepository::class)
 */
class Espece
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="espece", type="string", length=50, nullable=false)
     */
    private $espece;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEspece(): ?string
    {
        return $this->espece;
    }

    public function setEspece(string $espece): self
    {
        $this->espece = $espece;

        return $this;
    }

    
    public function __toString(){
        return $this->espece;
    }


}
