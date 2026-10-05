<?php

namespace App\Entity;
use App\Repository\TrainingRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: TrainingRepository::class)]
#[Table(name:'training')]
class Training
{
    #[Id]
    #[Column(type:'integer'), GeneratedValue]
    private ?int $id = null;
    #[Column(type:'string', length:"100", nullable: false )]
    #[Assert\Type('string') , Assert\NotBlank]
    private string $schoolname;
    #[Column(type:'string', nullable: true)]
    #[Assert\Type('string')]
    private ?string $description;
    #[Column(type:'string' , nullable: true)]
    #[Assert\Type('string')]
    private ?string $periode;


    public function getId(): ?Int {
        return $this->id;
    }

    public function GetSchoolName(): string {
        return $this->schoolname;
    }

    public function SetSchoolName($newschoolname){
        $this->schoolname=$newschoolname;
    }

    public function GetDescription(){
        return $this->description;
    }

    public function SetDescription($newdescription){
        $this->description=$newdescription;
    }

    public function GetPeriode(){
        return $this->periode;
    }

    public function SetPeriode($newperiode){
        $this->periode=$newperiode;
    }

}
