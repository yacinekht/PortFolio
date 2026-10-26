<?php

namespace App\Controller;

use App\Repository\ExperienceRepository;
use App\Repository\PassionRepository;
use App\Repository\SkillRepository;
use App\Repository\TrainingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
        // 1. Robot détecté (champ caché rempli) : on ignore sans rien dire
        if ($request->request->get('website')) {
            return $this->redirectToRoute('HomeController');
        }

        // 2. Jeton CSRF
        if (!$this->isCsrfTokenValid('telegram_message', (string) $request->request->get('_token'))) {
            $this->addFlash('error', 'Formulaire expiré, rechargez la page.');
            return $this->redirectToRoute('HomeController');
        }

        $name = trim((string) $request->request->get('visitor_name'));
        $messageContent = trim((string) $request->request->get('visitor_message'));

        // 3. Validation
        if ($name === '' || $messageContent === '' || mb_strlen($name) > 80 || mb_strlen($messageContent) > 1000) {
            $this->addFlash('error', 'Message invalide.');
            return $this->redirectToRoute('HomeController');
        }

        // 4. Message avec infos sur l'expéditeur
        $text = sprintf(
            "🚀 <b>Nouveau message du Portfolio !</b>\n\n<b>De :</b> %s\n<b>Message :</b>\n%s\n\n🌐 <b>IP :</b> %s\n📱 <b>Appareil :</b> %s\n🔗 <b>Provenance :</b> %s\n🕐 %s",
            htmlspecialchars($name),
            htmlspecialchars($messageContent),
            $request->getClientIp(),
            htmlspecialchars(substr((string) $request->headers->get('User-Agent'), 0, 120)),
            htmlspecialchars((string) ($request->headers->get('Referer') ?? 'direct')),
            (new \DateTime())->format('d/m/Y H:i:s')
        );

        $token = $_ENV['TELEGRAM_BOT_TOKEN'] ?? $_SERVER['TELEGRAM_BOT_TOKEN'] ?? getenv('TELEGRAM_BOT_TOKEN');
        $url = sprintf('https://api.telegram.org/bot%s/sendMessage', trim((string) $token));

        try {
            $client = HttpClient::create();
            $response = $client->request('POST', $url, [
                'json' => [
                    'chat_id' => '2107507530',
                    'text' => $text,
                    'parse_mode' => 'HTML',
                ],
                'timeout' => 5,
            ]);
            $ok = $response->getStatusCode() === 200;
        } catch (\Throwable $e) {
            $ok = false;
        }

        if (!$ok) {
            $this->addFlash('error', "Le message n'a pas pu être envoyé, réessayez plus tard.");
            return $this->redirectToRoute('HomeController');
        }

        $this->addFlash('success', 'Votre message a bien été transmis à Yacine !');
        return $this->redirectToRoute('HomeController');
    }
}
