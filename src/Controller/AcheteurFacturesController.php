<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\FactureRepository;
use App\Repository\UserRepository;

final class AcheteurFacturesController extends AbstractController
{
    #[Route('/acheteur/factures', name: 'app_acheteur_factures')]
    public function index(FactureRepository $factureRepository, UserRepository $userRepository): Response
    {
        $user = $this->getUser();
        $factures = null;

        if($user->getAcheteur() != null) {
            $factures = $factureRepository->findBy(
                array('acheteur' => $user->getAcheteur()->getId())
            );

        }
        return $this->render('acheteur/factures/index.html.twig', [
            'factures' => $factures,
        ]);
    }
}
