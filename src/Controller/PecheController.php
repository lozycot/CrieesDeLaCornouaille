<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Peche;
use App\Form\PecheType;

#[Route('/admin/peches')]
final class PecheController extends AbstractController
{
    #[Route('', name: 'app_peches')]
    public function index(): Response
    {
        return $this->render('admin/peches/index.html.twig', [
            'controller_name' => 'PechesController',
        ]);
    }

    #[Route(path: '/ajouter', name: 'app_admin_ajouter_peches', methods: ['GET', 'POST'])]
    public function ajouter(Request $request, EntityManagerInterface $manager): Response
    {
        $newPeche = new Peche();
        $form = $this->createForm(PecheType::class, $newPeche);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($newPeche);
            // écrire dans la base de données :
            $manager->flush();

            $this->addFlash('success', 'La pêche a bien été ajoutée.');
            return $this->redirectToRoute('app_admin_ajouter_peches');
        }
        return $this->render('admin/peches/ajouter.html.twig', [
            'form' => $form,
        ]);
    }
}
