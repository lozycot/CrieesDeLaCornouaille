<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Vente;
use App\Form\VenteType;
use App\Repository\VenteRepository;

#[Route('/admin/ventes')]
final class AdminVenteController extends AbstractController
{
    #[Route('', name: 'app_ventes')]
    public function index(VenteRepository $repo): Response
    {
        return $this->render('admin/ventes/index.html.twig', [
            'ventes' => $repo->findAll(),
        ]);
    }

    #[Route(path: '/ajouter', name: 'app_admin_ajouter_ventes', methods: ['GET', 'POST'])]
    public function ajouter(Request $request, EntityManagerInterface $manager): Response
    {
        $newVente = new Vente();
        $form = $this->createForm(VenteType::class, $newVente);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($newVente);
            // écrire dans la base de données :
            $manager->flush();

            $this->addFlash('success', 'La vente a bien été ajoutée.');
            return $this->redirectToRoute('app_admin_ajouter_ventes');
        }
        return $this->render('admin/ventes/ajouter.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/modifier/{id}', name: 'app_admin_modifier_vente', methods: ['GET', 'POST'])]
    public function modifier(Request $request, EntityManagerInterface $manager, Vente $vente): Response
    {
        $form = $this->createForm(VenteType::class, $vente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();
            $this->addFlash('success', 'La vente a bien été modifiée.');
            return $this->redirectToRoute('app_ventes');
        }

        return $this->render('admin/ventes/ajouter.html.twig', [
            'form' => $form,
            'edit_mode' => true,
        ]);
    }

    #[Route('/supprimer/{id}', name: 'app_admin_supprimer_vente', methods: ['POST'])]
    public function supprimer(Request $request, EntityManagerInterface $manager, Vente $vente): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vente->getId(), $request->request->get('_token'))) {
            $manager->remove($vente);
            $manager->flush();
            $this->addFlash('success', 'La vente a bien été supprimée.');
        }
        return $this->redirectToRoute('app_ventes');
    }

    #[Route('/supprimer', name: 'app_admin_supprimer_vente_liste')]
    public function supprimerListe(VenteRepository $repo): Response
    {
        return $this->render('admin/ventes/supprimer.html.twig', [
            'ventes' => $repo->findAll(),
        ]);
    }
}
