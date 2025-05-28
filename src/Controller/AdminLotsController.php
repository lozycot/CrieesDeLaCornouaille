<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Lot;
use App\Form\LotType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\LotRepository;

#[Route('/admin/lots')]
class AdminLotsController extends AbstractController{

    #[Route(path: '', name: 'app_admin_lots')]
    public function index(LotRepository $repo): Response
    {
        return $this->render('admin/lots/index.html.twig', [
            'lots' => $repo->findAll(),
        ]);
    }

    #[Route(path: '/ajouter', name: 'app_admin_ajouter_lots', methods: ['GET', 'POST'])]
    public function ajouter(Request $request, EntityManagerInterface $manager): Response
    {
        $newLot = new Lot();
        $form = $this->createForm(LotType::class, $newLot);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($newLot);
            // écrire dans la base de données :
            $manager->flush();

            $this->addFlash('success', 'Le lot a bien été ajouté.');
            return $this->redirectToRoute('app_admin_ajouter_lots');
        }
        return $this->render('admin/lots/ajouter.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/modifier/{id}', name: 'app_admin_modifier_lot', methods: ['GET', 'POST'])]
    public function modifier(Request $request, EntityManagerInterface $manager, Lot $lot): Response
    {
        $form = $this->createForm(LotType::class, $lot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();
            $this->addFlash('success', 'Le lot a bien été modifié.');
            return $this->redirectToRoute('app_admin_lots');
        }

        return $this->render('admin/lots/ajouter.html.twig', [
            'form' => $form,
            'edit_mode' => true,
        ]);
    }

    // Sert à supprimer un lot spécifique
    // et à rediriger vers la liste des lots
    // On utilise le token CSRF pour sécuriser la suppression
    // On utilise la méthode POST pour éviter les suppressions accidentelles
    // C'est la seulle méthode qui supprime un lot
    // Elle est utilisée par supprimerListe()
    #[Route('/supprimer/{id}', name: 'app_admin_supprimer_lot', methods: ['POST'])]
    public function supprimer(Request $request, EntityManagerInterface $manager, Lot $lot): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lot->getId(), $request->request->get('_token'))) {
            $manager->remove($lot);
            $manager->flush();
            $this->addFlash('success', 'Le lot a bien été supprimé.');
        }
        return $this->redirectToRoute('app_admin_lots');
    }

    #[Route('/supprimer', name: 'app_admin_supprimer_lot_liste')]
    public function supprimerListe(LotRepository $repo): Response
    {
        return $this->render('admin/lots/supprimer.html.twig', [
            'lots' => $repo->findAll(),
        ]);
    }
}
