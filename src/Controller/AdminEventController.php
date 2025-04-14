<?php

namespace App\Controller;

use App\Entity\AjoutEvenement;
use App\Repository\AjoutEvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminEventController extends AbstractController
{
    #[Route('/admin/evenements', name: 'admin_evenements')]
    public function index(AjoutEvenementRepository $eventRepository): Response
    {
        $evenements = $eventRepository->findAll();

        return $this->render('admin_event/index.html.twig', [
            'evenements' => $evenements
        ]);
    }

    #[Route('/admin/evenement/{id}/supprimer', name: 'admin_evenement_supprimer')]
    public function supprimer(AjoutEvenement $evenement, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($evenement);
        $entityManager->flush();

        $this->addFlash('success', 'Événement supprimé avec succès.');

        return $this->redirectToRoute('admin_evenements');
    }
}