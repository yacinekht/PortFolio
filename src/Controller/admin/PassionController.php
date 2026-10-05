<?php

namespace App\Controller\admin;

use App\Entity\Passion;
use App\Form\PassionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class PassionController extends AbstractController
{
    #[Route('/admin/newPassion', name: 'new_Passion')]
    public function newPassion(Request $request, EntityManagerInterface $entityManager): Response
    {
        $passion = new Passion();
        $form = $this->createForm(PassionType::class, $passion);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($passion);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('/admin/passion_new.html.twig', [
            'form' => $form,
        ]);
    }
}
