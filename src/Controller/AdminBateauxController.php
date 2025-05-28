<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Bateau;
use App\Form\BateauType;
use App\Repository\BateauRepository;

#[Route('/admin/bateaux')]
final class AdminBateauxController extends AbstractController
{
    #[Route(path: '', name: 'app_bateaux')]
    public function index(BateauRepository $repo): Response
    {
        return $this->render('admin/bateaux/index.html.twig', [
            'bateaux' => $repo->findAll(),
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

    #[Route('/modifier/{id}', name: 'app_admin_modifier_bateau', methods: ['GET', 'POST'])]
    public function modifier(Request $request, EntityManagerInterface $manager, Bateau $bateau): Response
    {
        $form = $this->createForm(BateauType::class, $bateau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();
            $this->addFlash('success', 'Le bateau a bien été modifié.');
            return $this->redirectToRoute('app_bateaux');
        }

        return $this->render('admin/bateaux/ajouter.html.twig', [
            'form' => $form,
            'edit_mode' => true,
        ]);
    }

    #[Route('/supprimer/{id}', name: 'app_admin_supprimer_bateau', methods: ['POST'])]
    public function supprimer(Request $request, EntityManagerInterface $manager, Bateau $bateau): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bateau->getId(), $request->request->get('_token'))) {
            $manager->remove($bateau);
            $manager->flush();
            $this->addFlash('success', 'Le bateau a bien été supprimé.');
        }
        return $this->redirectToRoute('app_bateaux');
    }

    #[Route('/supprimer', name: 'app_admin_supprimer_bateau_liste')]
    public function supprimerListe(BateauRepository $repo): Response
    {
        return $this->render('admin/bateaux/supprimer.html.twig', [
            'bateaux' => $repo->findAll(),
        ]);
    }
}
