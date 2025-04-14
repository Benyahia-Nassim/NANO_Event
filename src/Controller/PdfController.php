<?php

namespace App\Controller;

use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;

class PdfController extends AbstractController
{
    #[Route('/telecharger/pdf', name: 'telecharger_pdf')]
    public function telechargerQrCode(Pdf $knpSnappyPdf, RequestStack $requestStack): Response
    {
        $session = $requestStack->getSession();
        $user = $this->getUser();

        if (!$user) {
            $this->addFlash('error', 'Connexion requise.');
            return $this->redirectToRoute('app_login');
        }

        // Vérifie que les infos de la dernière réservation existent en session
        if (!$session->has('nom_evenement') || !$session->has('reference') || !$session->has('email_utilisateur')) {
            $this->addFlash('error', 'QR code introuvable.');
            return $this->redirectToRoute('app_home');
        }

        $html = $this->renderView('reservation/pdf.html.twig', [
            'nom_evenement' => $session->get('nom_evenement'),
            'reference' => $session->get('reference'),
            'email_utilisateur' => $session->get('email_utilisateur'),
        ]);

        $filename = 'QR_Reservation_' . $session->get('reference');

        return new Response(
            $knpSnappyPdf->getOutputFromHtml($html),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $filename . '.pdf"',
            ]
        );
    }
}