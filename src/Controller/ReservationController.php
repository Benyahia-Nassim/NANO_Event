<?php

namespace App\Controller;

use App\Entity\AjoutEvenement;
use App\Entity\Reservation;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    #[Route('/admin/reservations', name: 'admin_reservations')]
    public function index(ReservationRepository $reservationRepository): Response
    {
        $reservations = $reservationRepository->findAll();

        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservations,
        ]);
    }

    #[Route('/reserver/{id}', name: 'reservation_create')]
    public function create(AjoutEvenement $ajoutEvenement, EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $reservation = new Reservation();
        $reservation->setUser($this->getUser());
        $reservation->setAjoutEvenement($ajoutEvenement);
        $reservation->setCreatedAt(new \DateTime());
        $reservation->setUpdatedAt(new \DateTime());
        $reservation->setIsPaid(false);

        $entityManager->persist($reservation);
        $entityManager->flush();

        $this->addFlash('success', 'Réservation enregistrée avec succès !');

        return $this->redirectToRoute('reservation_payment', [
            'id' => $reservation->getId()
        ]);
    }

    #[Route('/paiement/{id}', name: 'reservation_payment')]
    public function paiement(Reservation $reservation): Response
    {
        if (!$this->getUser() || $reservation->getUser() !== $this->getUser()) {
            $this->addFlash('danger', 'Accès non autorisé.');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('reservation/paiement.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    #[Route('/paiement/valider/{id}', name: 'reservation_valider_paiement')]
    public function validerPaiement(Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser() || $reservation->getUser() !== $this->getUser()) {
            $this->addFlash('danger', 'Accès non autorisé.');
            return $this->redirectToRoute('app_login');
        }

        $reservation->setIsPaid(true);
        $reservation->setUpdatedAt(new \DateTime());
        $entityManager->flush();

        $this->addFlash('success', 'Paiement confirmé avec succès !');

        // 🔁 Redirection vers la confirmation avec QR Code
        return $this->redirectToRoute('qr_code_confirmation', [
            'id' => $reservation->getId()
        ]);
    }
}