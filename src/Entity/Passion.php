<?php

namespace App\Entity;
use App\Repository\PassionRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Symfony\Component\Validator\Constraints as Assert;
#[Entity(repositoryClass: PassionRepository::class)]
#[Table(name: 'passion')]

class Passion
{

    #[Id]
    #[Column(type: 'integer'), GeneratedValue]
    private ?int $id=null;
    #[Column(type: 'string', nullable: false)]
    #[Assert\NotBlank, Assert\Type('string')]
    private string $passionname;
    #[Column(type:'string',nullable: true)]
    private ?string $passiondescription=null;


    public function getId(){
        return $this->id;
    }

    public function getPassionName(){
        return $this->passionname;
    }

    public function setPassionName($newpassionname){
        $this->passionname=$newpassionname;
    }

    public function getPassionDescription(){
        return $this->passiondescription;
    }

    public function setPassionDescription($newpassiondescription){
        $this->passiondescription=$newpassiondescription;
    }

}



