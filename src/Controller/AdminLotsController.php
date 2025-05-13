<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Lot;
use App\Form\LotType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/admin/lots')]
class AdminLotsController extends AbstractController{

    #[Route(path: '', name: 'app_admin_lots')]
    public function index(): Response
    {
        return $this->render('admin/lots/index.html.twig', [
            'controller_name' => 'LotsController',
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


}
