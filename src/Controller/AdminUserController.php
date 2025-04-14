<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminUserController extends AbstractController
{
    #[Route('/admin/utilisateurs', name: 'admin_utilisateurs')]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        return $this->render('admin_user/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/admin/utilisateur/{id}/bloquer', name: 'admin_utilisateur_bloquer')]
    public function bloquer(User $user, EntityManagerInterface $entityManager): Response
    {
        $roles = $user->getRoles();

        if (in_array('ROLE_BLOQUE', $roles)) {
            // Supprime uniquement ROLE_BLOQUE
            $roles = array_diff($roles, ['ROLE_BLOQUE']);
            $this->addFlash('success', 'Utilisateur débloqué avec succès.');
        } else {
            // Ajoute ROLE_BLOQUE
            $roles[] = 'ROLE_BLOQUE';
            $this->addFlash('warning', 'Utilisateur bloqué avec succès.');
        }

        // On garantit toujours au moins ROLE_USER
        if (!in_array('ROLE_USER', $roles)) {
            $roles[] = 'ROLE_USER';
        }

        // On s'assure que ROLE_ADMIN reste si déjà présent
        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            $roles[] = 'ROLE_ADMIN';
        }

        $user->setRoles(array_unique($roles));
        $entityManager->flush();

        return $this->redirectToRoute('admin_utilisateurs');
    }
}