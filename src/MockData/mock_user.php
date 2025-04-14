<?php

// src/MockData/mock_user.php
return [
    'id' => 1,
    'nom' => 'Doe',
    'prenom' => 'John',
    'email' => 'john.doe@example.com',
    'telephone' => '0123456789',
    'adresse' => '123 Rue de Paris',
    'ville' => 'Paris',
    'codePostal' => '75001',
    'password' => 'hashedpassword',  // Remplacer par un mot de passe "haché" pour simuler
    'createdAt' => new \DateTime('now'),
    'updatedAt' => new \DateTime('now')
];