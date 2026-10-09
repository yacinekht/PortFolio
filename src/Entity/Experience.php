<?php

namespace App\Entity;

use App\Repository\ExperienceRepository;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Symfony\Component\Validator\Constraints as Assert;

#[Entity(repositoryClass: ExperienceRepository::class)]
#[Table(name: 'experience')]
class Experience
{

    #[Id]
    #[Column(type: 'integer'), GeneratedValue]
    private ?int $id=null;
    #[Column(type: 'text', nullable: false)]
    #[Assert\Type('string'), Assert\NotBlank]
    private string $experiencename;

    #[Column(type:'text', nullable: true)]
    private ?string $experiencedescription=null;
    #[Column(type: 'string', nullable: true)]
    private ?string $experiencedate=null;


    public function getId(): ?int {
        return $this->id;
    }

    public function getExperienceName(): string {
        return $this->experiencename;
    }

    public function setExperienceName($newexperiencename){
        $this->experiencename=$newexperiencename;
    }

    public function getExperienceDescription(){
        return $this->experiencedescription;
    }

    public function setExperienceDescription($newexperiencedescription){
        $this->experiencedescription=$newexperiencedescription;
    }

    public function getExperienceDate(){
        return $this->experiencedate;
    }

    public function setExperienceDate($newexperiencedate){
        $this->experiencedate=$newexperiencedate;
    }
}
