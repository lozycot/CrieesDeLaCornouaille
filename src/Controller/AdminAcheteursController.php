<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Acheteur;
use App\Form\AcheteurType;
use App\Repository\UserRepository;
use App\Repository\AcheteurRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/admin/acheteurs')]
class AdminAcheteursController extends AbstractController{

    #[Route(path: '', name: 'app_admin_acheteurs')]
    public function index(AcheteurRepository $repo): Response
    {
        return $this->render('admin/acheteurs/index.html.twig', [
            'acheteurs' => $repo->findAll(),
        ]);
    }

    #[Route(path: '/ajouter', name: 'app_admin_ajouter_acheteur', methods: ['GET', 'POST'])]
    public function ajouter(Request $request, EntityManagerInterface $manager, UserRepository $userRepo): Response
    {
        // $idUser = $request->query->get('idUser');
        // $message = '';
        // $message = 'id = '.$idUser;
        // $chaineUtilisateur = '';
        // if($idUser != null) {
        //     $user = $userRepo->findBy(array('id' => $idUser));
        //     if(sizeof($user)>0) {
        //         $username = $user[0]->getLogin();
        //         $userEmail = $user[0]->getEmail();
        //         $this->addFlash('info', 'Renseigner les informations d\'acheteur pour '.$username.'.');
        //         $chaineUtilisateur = $idUser;
        //     }
        // }
        
        $newAcheteur = new Acheteur();
        $form = $this->createForm(AcheteurType::class, $newAcheteur);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($newAcheteur);
            // écrire dans la base de données :
            $manager->flush();

            $this->addFlash('success', 'L\'acheteur a bien été créé.');
            return $this->redirectToRoute('app_admin_ajouter_acheteur');
        }
        return $this->render('admin/acheteurs/ajouter.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/modifier/{id}', name: 'app_admin_modifier_acheteur', methods: ['GET', 'POST'])]
    public function modifier(Request $request, EntityManagerInterface $manager, Acheteur $acheteur): Response
    {
        $form = $this->createForm(AcheteurType::class, $acheteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();
            $this->addFlash('success', 'L\'acheteur a bien été modifié.');
            return $this->redirectToRoute('app_admin_acheteurs');
        }

        return $this->render('admin/acheteurs/ajouter.html.twig', [
            'form' => $form,
            'edit_mode' => true,
        ]);
    }

    #[Route('/supprimer/{id}', name: 'app_admin_supprimer_acheteur', methods: ['POST'])]
    public function supprimer(Request $request, EntityManagerInterface $manager, Acheteur $acheteur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$acheteur->getId(), $request->request->get('_token'))) {
            $manager->remove($acheteur);
            $manager->flush();
            $this->addFlash('success', 'L\'acheteur a bien été supprimé.');
        }
        return $this->redirectToRoute('app_admin_acheteurs');
    }

    #[Route('/supprimer', name: 'app_admin_supprimer_acheteur_liste')]
    public function supprimerListe(AcheteurRepository $repo): Response
    {
        return $this->render('admin/acheteurs/supprimer.html.twig', [
            'acheteurs' => $repo->findAll(),
        ]);
    }
}
