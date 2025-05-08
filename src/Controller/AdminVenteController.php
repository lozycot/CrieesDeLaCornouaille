<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Vente;
use App\Form\VenteType;

#[Route('/admin/ventes')]
final class AdminVenteController extends AbstractController
{
    #[Route('', name: 'app_ventes')]
    public function index(): Response
    {
        return $this->render('admin/ventes/index.html.twig', [
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
}
