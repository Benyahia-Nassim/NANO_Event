<?php

namespace App\Controller;

use App\Entity\Reservation;
use Dompdf\Dompdf;
use Dompdf\Options;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class QrCodeGeneratorController extends AbstractController
{
    #[Route('/qr/code/generator', name: 'app_qr_code_generator')]
    public function index(): Response
    {
        return $this->render('qr_code_generator/index.html.twig');
    }

    #[Route('/qr/confirmation/{id}', name: 'qr_code_confirmation')]
    public function confirmation(Reservation $reservation): Response
    {
        if (!$this->getUser() || $reservation->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('qr_code_generator/confirmation.html.twig', [
            'reservation' => $reservation
        ]);
    }

    #[Route('/qr/code/download/{id}', name: 'qr_code_download_pdf')]
    public function download(Request $request, Reservation $reservation): Response
    {
        if (!$this->getUser() || $reservation->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        // ✅ Construction du QR Code
        $qrResult = Builder::create()
            ->writer(new PngWriter())
            ->data('Réservation SP_EVENT : '.$reservation->getId())
            ->size(200)
            ->margin(10)
            ->build();

        $qrBase64 = $qrResult->getDataUri();

        // ✅ Données à afficher
        $user = $reservation->getUser();
        $event = $reservation->getAjoutEvenement();

        // ✅ Chemin de l’image d’événement (si elle existe)
        $eventImagePath = null;
        if ($event->getImage()) {
            $eventImagePath = $this->getParameter('kernel.project_dir') . '/public/uploads/' . $event->getImage();
            if (file_exists($eventImagePath)) {
                $eventImagePath = 'data:image/png;base64,' . base64_encode(file_get_contents($eventImagePath));
            } else {
                $eventImagePath = null;
            }
        }

        // ✅ Génération HTML
        $html = $this->renderView('qr_code_generator/pdf_template.html.twig', [
            'qrCode' => $qrBase64,
            'nom' => $user->getNom() . ' ' . $user->getPrenom(),
            'email' => $user->getEmail(),
            'titre' => $event->getTitre(),
            'date' => \DateTime::createFromFormat('d/m/Y', $event->getDate())?->format('d F Y') ?? $event->getDate(),
            'ville' => $event->getVille(),
            'eventImage' => $eventImagePath
        ]);

        // ✅ Configuration de DomPDF
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($pdfOptions);
        $dompdf->loadHtml($html);
        $dompdf->render();

        return new Response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="qr_code_reservation.pdf"'
        ]);
    }
}