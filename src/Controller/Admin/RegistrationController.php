<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\ExpressionLanguage\Expression;

class RegistrationController extends AbstractController
{
    #[IsGranted(new Expression('is_granted("ROLE_ADMIN")'))]
    #[Route('/admin/user/new', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();
            $user->setEmail($form->get('email')->getData());

            // encode the plain password
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'L\'utilisateur a bien été ajouté.');

            // vérifier si la case "Acheteur-ice" a été cochée
            $estAcheteur = false;
            echo 'roles: '.var_dump($user->getRoles());
            foreach($user->getRoles() as $role) {
                if($role == 'ROLE_ACHETEUR')
                    $estAcheteur = true;
            }

            // Si c'est un-e Acheteur-ice, rediriger vers la page création d'acheteur
            if($estAcheteur){
                // message à afficher
                $this->addFlash('info', 'Ajoutez les informations d\'acheteur pour '.$user->getLogin());
                return $this->redirectToRoute('app_admin_ajouter_acheteur', [
                    // 'idUser' => $user->getId(),
                ]);   
            }
            // Sinon rediriger vers l'accueil
            else
                return $this->redirectToRoute('app_accueil');
        }

        return $this->render('admin/registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }
}
