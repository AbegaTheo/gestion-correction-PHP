# Gestion de Corrections - PHP/MySQL

Ce projet est une application web de gestion des corrections d'épreuves, permettant la saisie, la consultation, la modification et la suppression des données liées aux établissements, professeurs, examens, épreuves et corrections.

## Fonctionnalités principales
- **Formulaire de saisie** (manuel) pour toutes les entités (établissement, professeur, examen, épreuve, correction)
- **Affichage** de toutes les tables principales dans une page de liste moderne
- **Modification** (CRUD) de chaque ligne via un formulaire pré-rempli
- **Suppression** sécurisée de chaque ligne, avec gestion manuelle des dépendances (voir plus bas)
- **Navigation simple** entre le formulaire et la liste

## Installation
1. **Prérequis** :
   - PHP 7+
   - MySQL/MariaDB (ex : XAMPP, WAMP, MAMP...)
   - Navigateur web

2. **Base de données** :
   - Crée une base nommée `gestion correction` dans PhpMyAdmin.
   - Exécute le script SQL fourni pour créer les tables :
     - ETABLISSEMENT
     - PROFESSEUR
     - EXAMEN
     - EPREUVE
     - CORRIGER
     - SURVEILLER
   - (Optionnel) Ajoute des données de test.

3. **Fichiers à placer dans le dossier du projet** (ex : `htdocs/gestion de corrections/`)
   - `controllers/formulaire_correction.php` : Formulaire d'ajout
   - `controllers/liste_tables.php` : Affichage et gestion CRUD
   - `controllers/modifier.php` : Modification générique
   - `controllers/supprimer.php` : Suppression générique
   - `inclure/navbar.php` et `inclure/footer.php` : Barre de navigation et pied de page
   - `config/db.php` : Connexion centralisée à la base

4. **Accès** :
   - Ouvre `http://localhost/gestion%20de%20corrections/controllers/formulaire_correction.php` dans ton navigateur.

## Utilisation
- **Ajouter** : Remplis le formulaire et valide. Tu seras redirigé vers la liste.
- **Modifier** : Clique sur "Modifier" à côté d'une ligne, corrige et enregistre.
- **Supprimer** : Clique sur "Supprimer" à côté d'une ligne (confirmation demandée). Les dépendances (corrections, surveillances, etc.) sont supprimées automatiquement si besoin.
- **Retour** : Utilise le bouton pour revenir au formulaire d'ajout.

## Gestion des dépendances et mises à jour
- Lors de la suppression d'un professeur, toutes ses corrections et surveillances sont supprimées automatiquement.
- Lors de la suppression d'un établissement, toutes les corrections et surveillances des professeurs de cet établissement sont supprimées.
- Lors de l'ajout ou modification d'un examen, **si le code_examen existe déjà, le nom_examen est automatiquement mis à jour**.
- Les suppressions sont gérées manuellement dans le code PHP pour éviter toute erreur de clé étrangère.

## Structure des fichiers
- `controllers/formulaire_correction.php` : Saisie manuelle, insertion dans toutes les tables
- `controllers/liste_tables.php` : Affichage de toutes les tables, liens d'action CRUD
- `controllers/modifier.php` : Formulaire de modification dynamique selon la table
- `controllers/supprimer.php` : Suppression sécurisée d'une ligne et de ses dépendances
- `inclure/navbar.php` et `inclure/footer.php` : Navigation et pied de page
- `config/db.php` : Connexion MySQL centralisée

## Sécurité & Conseils
- Les clés primaires sont saisies manuellement (pas d'auto-increment)
- Les suppressions demandent une confirmation
- Les modifications ne permettent pas de changer la clé primaire
- Pense à sauvegarder ta base avant toute opération massive

## Personnalisation
- Tu peux adapter le style CSS dans chaque fichier pour correspondre à ta charte graphique.
- Pour ajouter des validations ou des contrôles supplémentaires, modifie le code PHP selon tes besoins.

---

**Projet réalisé pour la gestion efficace des corrections d'épreuves en environnement éducatif.** 