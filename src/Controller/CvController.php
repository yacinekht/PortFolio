<?php

namespace App\Controller;

use App\Repository\CvDocumentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

class CvController extends AbstractController
{
    #[Route('/cv', name: 'app_cv_download')]
    public function download(CvDocumentRepository $repo): Response
    {
        $cv = $repo->findOneBy([], ['id' => 'DESC']);

        if (!$cv || $cv->getContent() === null) {
            throw new NotFoundHttpException('Aucun CV disponible.');
        }

        $content = $cv->getContent();
        $data = is_resource($content) ? stream_get_contents($content) : $content;

        return new Response($data, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="CV.pdf"',
        ]);
    }
}
