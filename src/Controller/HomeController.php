<?php

namespace App\Controller;

use App\Repository\ExperienceRepository;
use App\Repository\PassionRepository;
use App\Repository\SkillRepository;
use App\Repository\TrainingRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route("/",name:"HomeController")]

    public function index(SkillRepository $skillRepository, TrainingRepository $trainingRepository,
                                                        PassionRepository $passionRepository ,
                                                        ExperienceRepository $experienceRepository) : Response {

        $skills=$skillRepository->findAll();
        $skillsGroupes =[];

        $training=$trainingRepository->findAll();

        $passion=$passionRepository->findAll();
        $experience=$experienceRepository->findAll();




        foreach($skills as $skill){
            $nom= $skill->getName();
            $category= $skill->getCategory();
            $position= $skill->getPosition();

            $skillsGroupes[$category][] = $nom ;
        }


        return $this->render("Home/index.html.twig", [
            'skills'=> $skillsGroupes,
            'trainings'=>$training,
            'passions'=>$passion,
            'experiences'=>$experience,

        ]);

    }
}
