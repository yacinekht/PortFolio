<?php

namespace App\Controller;

use App\Repository\ExperienceRepository;
use App\Repository\PassionRepository;
use App\Repository\SkillRepository;
use App\Repository\TrainingRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route("/", name: "HomeController")]
    public function index(
        SkillRepository $skillRepository,
        TrainingRepository $trainingRepository,
        PassionRepository $passionRepository,
        ExperienceRepository $experienceRepository
    ): Response {
        $skills = $skillRepository->findAll();
        $skillsGroupes = [];

        $training = $trainingRepository->findAll();
        $passion = $passionRepository->findAll();
        $experience = $experienceRepository->findBy([], ['id' => 'DESC']);

        foreach ($skills as $skill) {
            $nom = $skill->getName();
            $category = $skill->getCategory();

            $skillsGroupes[$category][] = $nom;
        }

        return $this->render("Home/index.html.twig", [
            'skills' => $skillsGroupes,
            'trainings' => $training,
            'passions' => $passion,
            'experiences' => $experience,
        ]);
    }

    #[Route('/send-telegram', name: 'app_send_telegram_message', methods: ['POST'])]
    public function sendTelegram(Request $request): Response
    {
        $name = (string) $request->request->get('visitor_name');
        $messageContent = (string) $request->request->get('visitor_message');

        $text = sprintf(
            "🚀 <b>Nouveau message du Portfolio !</b>\n\n<b>De :</b> %s\n<b>Message :</b>\n%s",
            htmlspecialchars($name),
            htmlspecialchars($messageContent)
        );

        $token = $_ENV['TELEGRAM_BOT_TOKEN'] ?? $_SERVER['TELEGRAM_BOT_TOKEN'] ?? getenv('TELEGRAM_BOT_TOKEN');
        $url = sprintf('https://api.telegram.org/bot%s/sendMessage', trim((string) $token));

        $client = \Symfony\Component\HttpClient\HttpClient::create();
        $response = $client->request('POST', $url, [
            'json' => [
                'chat_id' => '2107507530',
                'text' => $text,
                'parse_mode' => 'HTML',
            ],
        ]);

        if ($response->getStatusCode() !== 200) {
            $this->addFlash('error', "Le message n'a pas pu être envoyé, réessayez plus tard.");
            return $this->redirectToRoute('HomeController');
        }

        $this->addFlash('success', 'Votre message a bien été transmis à Yacine !');
        return $this->redirectToRoute('HomeController');
    }
}
