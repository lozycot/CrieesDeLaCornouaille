<?php
namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/admin/user/new', name: 'admin_user_new')]
    public function new(): Response
    {
        // TODO: implement user creation form and logic
        return $this->render('admin/user/new.html.twig');
    }
}
