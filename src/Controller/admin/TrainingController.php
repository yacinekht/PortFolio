<?php

namespace App\Controller\admin;

use App\Entity\Training;
use App\Form\TrainingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class TrainingController extends AbstractController
{
    #[Route('/admin/newTraining', name:'new_Training')]
    public function newTraining(Request $request, EntityManagerInterface $entityManager): Response {

        $training = new Training();
        $form=$this->createForm(TrainingType::class , $training);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($training);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin');
        }

            return $this->render('/admin/training_new.html.twig',[
               'form'=> $form
            ]);

    }
}
