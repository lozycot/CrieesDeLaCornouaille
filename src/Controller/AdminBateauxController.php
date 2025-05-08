<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Bateau;
use App\Form\BateauType;

#[Route('/admin/bateaux')]
final class AdminBateauxController extends AbstractController
{
    #[Route('', name: 'app_bateaux')]
    public function index(): Response
    {
        return $this->render('admin/bateaux/index.html.twig', [
            'controller_name' => 'BateauxController',
        ]);
    }

    #[Route(path: '/ajouter', name: 'app_admin_ajouter_bateaux', methods: ['GET', 'POST'])]
    public function ajouter(Request $request, EntityManagerInterface $manager): Response
    {
        $newBateau = new Bateau();
        $form = $this->createForm(BateauType::class, $newBateau);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($newBateau);
            // écrire dans la base de données :
            $manager->flush();

            $this->addFlash('success', 'Le bateau a bien été ajouté.');
            return $this->redirectToRoute('app_admin_ajouter_bateaux');
        }
        return $this->render('admin/bateaux/ajouter.html.twig', [
            'form' => $form,
        ]);
    }
}
