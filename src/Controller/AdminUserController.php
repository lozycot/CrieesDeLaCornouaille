<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\UserEditType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/users')]
class AdminUserController extends AbstractController
{
    // Liste pour "Modifier des utilisateurs"
    #[Route('/modifier', name: 'admin_user_modifier_liste')]
    public function modifierListe(UserRepository $repo): Response
    {
        return $this->render('admin/user/modifier.html.twig', [
            'users' => $repo->findAll(),
        ]);
    }

    // Liste pour "Supprimer des utilisateurs"
    #[Route('/supprimer', name: 'admin_user_supprimer_liste')]
    public function supprimerListe(UserRepository $repo): Response
    {
        return $this->render('admin/user/supprimer.html.twig', [
            'users' => $repo->findAll(),
        ]);
    }

    // Formulaire d'ajout (si vous avez déjà une route pour ça, gardez-la)
    #[Route('/ajouter', name: 'admin_user_ajouter', methods: ['GET', 'POST'])]
    public function ajouter(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $hasher): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($hasher->hashPassword($user, $form->get('plainPassword')->getData()));
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', 'Utilisateur ajouté.');
            return $this->redirectToRoute('admin_user_ajouter');
        }

        return $this->render('admin/user/ajouter.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('', name: 'admin_users')]
    public function index(UserRepository $repo): Response
    {
        return $this->render('admin/user/index.html.twig', [
            'users' => $repo->findAll(),
        ]);
    }

    #[Route('/edit/{id}', name: 'admin_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $manager, User $user): Response
    {
        $form = $this->createForm(UserEditType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();
            $this->addFlash('success', 'Utilisateur modifié.');
            return $this->redirectToRoute('admin_users');
        }

        return $this->render('admin/user/edit.html.twig', [
            'form' => $form,
            'user' => $user,
        ]);
    }

    #[Route('/delete/{id}', name: 'admin_user_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        EntityManagerInterface $manager,
        User $user,
        UserPasswordHasherInterface $hasher
    ): Response {
        $adminPassword = $request->request->get('admin_password');
        $currentAdmin = $this->getUser();

        if (!$hasher->isPasswordValid($currentAdmin, $adminPassword)) {
            $this->addFlash('danger', 'Mot de passe administrateur incorrect.');
            return $this->redirectToRoute('admin_users');
        }

        $manager->remove($user);
        $manager->flush();
        $this->addFlash('success', 'Utilisateur supprimé.');
        return $this->redirectToRoute('admin_users');
    }
}