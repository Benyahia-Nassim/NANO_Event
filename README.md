# Projet Symfony : NANO_EVENT

## 🎯 Objectif du projet
NANO_EVENT est une plateforme de gestion d'événements avec système de réservation, QR code, back-office administrateur et tableau de bord.
Ce projet Symfony est conçu comme démonstration technique complète (auth, PDF, admin, QR code...)

## ✅ Fonctionnalités terminées

### 👤 Authentification
- Inscription / Connexion utilisateur
- Rôles `ROLE_USER`, `ROLE_ADMIN`, `ROLE_BLOQUE`

### 🎟 Réservations
- Réserver un événement connecté
- Génération QR code après paiement fictif
- Téléchargement du billet PDF avec QR

### 📦 Back Office Admin
- Accès restreint à `/admin`
- Dashboard avec stats : utilisateurs, événements, réservations
- Gestion des utilisateurs : bloquer/débloquer (hors admins)
- Gestion des événements : suppression d’un événement
- Liste des réservations admin

### 📄 PDF & QR Code
- QR code généré à la réservation (Endroid)
- Dompdf intégré pour PDF personnalisé
- Affiche : QR, infos utilisateur, titre de l’événement, image de fond, logo NANO_EVENT

### 📁 Environnement
- Projet fonctionnel en local sous Symfony CLI + PHP + SQLite
- Compatible avec XAMPP (PHP, MySQL dispo)
- Utilise Twig, Doctrine, WebProfiler, MakerBundle

## 📌 TDL (ToDoList : à venir)

### 🔄 Améliorations fonctionnelles
- [ ] Envoi du QR code PDF par email à la réservation
- [ ] Passage de `AjoutEvenement.date` en `DateTimeImmutable`
- [ ] Système de paiement réel (Stripe ou autre)

### 📊 Back Office
- [ ] Intégration de graphiques statistiques (ex : nb réservations/mois)
- [ ] Filtres dynamiques pour les tables admin (JS/DataTables)
- [ ] Pagination des utilisateurs, événements, réservations

### 🛠 Technique
- [ ] Migration complète vers base MySQL
- [ ] Création d’un `.env.local.example`
- [ ] Création d’un fichier `.gitignore`
- [ ] Tests unitaires / E2E avec PHPUnit

### 🧾 Formulaires et validation
- [ ] Ajouter contraintes de validation précises (longueur nom, tel, code postal...)
- [ ] Sécuriser tous les champs (XSS / CSRF déjà activé par défaut avec Twig)

## 🚀 Lancer le projet localement
```bash
symfony serve
```
Ou en utilisant XAMPP :
```bash
php -S localhost:8000 -t public
```

## 🧠 Contributeur
Projet développé dans une logique d'apprentissage productif. Toute PR / amélioration est la bienvenue.

---

✅ Projet validé et présentable !
📦 Prêt pour démonstration.

---

> Dernière mise à jour : 14/04/2025
