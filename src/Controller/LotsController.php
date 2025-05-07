<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Lot;
use App\Form\LotType;
use App\Repository\LotRepository;

class LotsController extends AbstractController{

    #[Route(path: '/admin/lots', name: 'app_admin_lots')]
    public function index(): Response
    {
        return $this->render('admin/lots/index.html.twig', [
            'controller_name' => 'LotsController',
        ]);
    }

    #[Route(path: '/admin/lots/ajouter', name: 'app_admin_ajouter_lots')]
    public function ajouter(): Response
    {
        $newLot = new Lot();
        $form = $this->createForm(LotType::class, $newLot);
        
        return $this->render('admin/lots/ajouter.html.twig', [
            'controller_name' => 'LotsController',
            'form' => $form,
        ]);
    }


}
