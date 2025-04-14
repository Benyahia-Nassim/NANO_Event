<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(): Response
    {
        $user = $this->getUser(); // Récupère l'utilisateur connecté

        return $this->render('profil/index.html.twig', [
            'user' => $user, // On transmet l'utilisateur à Twig
        ]);
    }
}

 /*      version Phil ^^
 
 return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
        ]);
    }
}

/*
$mockUser = [
    'nom' => 'Doe',
    'prenom' => 'John',
    'email' => 'johndoe@example.com',
    'telephone' => '0600000000',
    'adresse' => '123 Rue du Test',
    'ville' => 'Paris',
    'codePostal' => '75000',
];
parti gpt laforge
*/