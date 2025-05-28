<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Peche;
use App\Form\PecheType;
use App\Repository\PecheRepository;

#[Route('/admin/peches')]
final class AdminPecheController extends AbstractController
{
    #[Route(path: '', name: 'app_peches')]
    public function index(PecheRepository $repo): Response
    {
        return $this->render('admin/peches/index.html.twig', [
            'peches' => $repo->findAll(),
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

    #[Route('/modifier/{id}', name: 'app_admin_modifier_peche', methods: ['GET', 'POST'])]
    public function modifier(Request $request, EntityManagerInterface $manager, Peche $peche): Response
    {
        $form = $this->createForm(PecheType::class, $peche);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();
            $this->addFlash('success', 'La pêche a bien été modifiée.');
            return $this->redirectToRoute('app_peches');
        }

        return $this->render('admin/peches/ajouter.html.twig', [
            'form' => $form,
            'edit_mode' => true,
        ]);
    }

    #[Route('/supprimer/{id}', name: 'app_admin_supprimer_peche', methods: ['POST'])]
    public function supprimer(Request $request, EntityManagerInterface $manager, Peche $peche): Response
    {
        if ($this->isCsrfTokenValid('delete'.$peche->getId(), $request->request->get('_token'))) {
            $manager->remove($peche);
            $manager->flush();
            $this->addFlash('success', 'La pêche a bien été supprimée.');
        }
        return $this->redirectToRoute('app_peches');
    }

    #[Route('/supprimer', name: 'app_admin_supprimer_peche_liste')]
    public function supprimerListe(PecheRepository $repo): Response
    {
        return $this->render('admin/peches/supprimer.html.twig', [
            'peches' => $repo->findAll(),
        ]);
    }
}
