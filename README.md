# Gestion des notes des étudiants 📜

Application web (SPA) pour gérer les étudiants et leurs notes.
Frontend en Vue 3, API REST en PHP, base de données MySQL.

## Fonctionnalités

- [Ajouter, modifier et supprimer un étudiant]
- [Saisir et consulter les notes]
- [Diagramme pour la moyenne, le statut des notes des etudiants.]

## Technologies

| Partie | Technologie |
|--------|-------------|
| Frontend | Vue 3, Vite |
| Backend | PHP (dossier `etudiant-api`) |
| Base de données | MySQL |
| Qualité du code | ESLint, Prettier |

## Structure du projet

    ├── src/            # code du frontend Vue
    ├── public/         # fichiers statiques
    ├── etudiant-api/   # API PHP
    └── database.sql    # script de création de la base

## Installation

1. Cloner le dépôt
       git clone https://github.com/donat-tsiry/Gestion-notes-desetudiants.git
       cd Gestion-notes-desetudiants
2. Créer la base de données : importer `database.sql` dans MySQL
3. Configurer la connexion MySQL dans `etudiant-api` [nom du fichier]
4. Lancer l'API PHP [par exemple avec XAMPP ou `php -S localhost:8000`]
5. Installer et lancer le frontend
       npm install
       npm run dev

## Captures d'écran

[Ajouter 2 ou 3 images dans un dossier `docs/` et les afficher ici]

## Auteur

Donat Tsiry, étudiant à l'École nationale d'informatique (Madagascar)
GitHub : [@donat-tsiry](https://github.com/donat-tsiry)
