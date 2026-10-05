<?php

namespace App\Controller\admin;

use App\Form\SkillType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Skill;
use Symfony\Component\Routing\Attribute\Route;

class SkillController extends AbstractController
{

    #[Route('/admin/Skill/new', name:'Skill_Controller')]
    public function newSkill(Request $request,EntityManagerInterface $entityManager ): Response {
            $skill = new Skill();
            $form = $this->createForm(SkillType::class , $skill);

            $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($skill);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin');
            // 1. prépare $skill pour l'enregistrement
            // 2. exécute réellement l'enregistrement
            // 3. redirige vers 'app_admin' avec $this->redirectToRoute(...)
        }

        return $this->render('admin/skill_new.html.twig', [
            'form' => $form,
        ]);


    }

}
