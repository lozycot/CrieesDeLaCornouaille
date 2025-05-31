<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Vente;
use App\Repository\VenteRepository;
use App\Service\VenteVerification;
use Datetime;

#[Route('/compta/factures')]
final class ComptaGenererFacturesController extends AbstractController
{
    #[Route(path: '/generer', name: 'app_compta_factures_generer', methods: ['POST'])]
    public function generer(Request $request, VenteRepository $venteRepo, VenteVerification $serviceVVerif): Response
    {
        $dateVente = null;
        if($this->isCsrfTokenValid('date', $request->request->get('_token'))) {
            $dateVente = Datetime::createFromFormat('Y-m-d', $request->request->get('la_date'));
            $vente = $venteRepo->findOneBy(array('dateVente' => $dateVente));
            $flash = $serviceVVerif->genererFactures($vente);
            $this->addFlash($flash['type'], $flash['content']);
            
        }
        return $this->redirectToRoute('app_compta_factures');
    }

    #[Route(path: '', name: 'app_compta_factures')]
    public function index(): Response
    {
        return $this->render('compta/generer_factures/index.html.twig', [
        ]);
    }


}
