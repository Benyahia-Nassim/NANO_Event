<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\AjoutEvenementRepository;
use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/admin', name: 'dashboard')]
    public function index(
        UserRepository $userRepository,
        AjoutEvenementRepository $eventRepository,
        ReservationRepository $reservationRepository
    ): Response {
        // Compter les entités
        $totalUsers = $userRepository->count([]);
        $totalEvents = $eventRepository->count([]);
        $totalReservations = $reservationRepository->count([]);

        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'total_users' => $totalUsers,
            'total_events' => $totalEvents,
            'total_reservations' => $totalReservations,
        ]);
    }
}