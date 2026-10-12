<?php

namespace App\Controller;

use App\Repository\ExperienceRepository;
use App\Repository\PassionRepository;
use App\Repository\SkillRepository;
use App\Repository\TrainingRepository;
use App\Service\TelegramService;
use Symfony\Component\HttpFoundation\Request;
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


    #[Route('/send-telegram', name: 'app_send_telegram_message', methods: ['POST'])]
    public function sendTelegram(Request $request, TelegramService $telegramService): Response
    {
        $name = $request->request->get('visitor_name');
        $messageContent = $request->request->get('visitor_message');

        $text = sprintf(
            "🚀 *Nouveau message du Portfolio !*\n\n*De :* %s\n*Message :*\n%s",
            $name,
            $messageContent
        );

        $telegramService->sendMessage($text);

        $this->addFlash('success', 'Votre message a bien été transmis à Yacine !');

        // Redirige vers la page d'accueil (vérifie que ta route d'accueil s'appelle bien 'home' ou ajuste selon ton code)
        return $this->redirectToRoute('HomeController');
    }

}
