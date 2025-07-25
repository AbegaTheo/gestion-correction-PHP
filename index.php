<!-- Page d'accueil de l'application -->

<?php
// Inclure l'autoloader
require_once __DIR__ . '/autoload.php';

use App\Views\Layout\Header;
use App\Views\Layout\Footer;

$header = new Header();
$header->render();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Gestion de correction</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .container {
            max-width: 700px;
            margin: 40px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.07);
            padding: 32px;
            text-align: center;
        }
        h1 {
            color: #007bff;
            margin-bottom: 18px;
        }
        .presentation {
            font-size: 1.15em;
            color: #444;
            margin-bottom: 24px;
        }
        .actions {
            display: flex;
            justify-content: center;
            gap: 24px;
            margin-top: 18px;
        }
        .actions a {
            background: #007bff;
            color: #fff;
            padding: 10px 22px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            transition: background 0.2s;
        }
        .actions a:hover {
            background: #0056b3;
        }
        footer {
            margin-top: 3rem;
            padding: 1.5rem;
            background-color: #f8f9fa;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Bienvenue sur l'application de gestion des corrections</h1>
        <div class="presentation">
            Cette plateforme vous permet de gérer facilement les professeurs, établissements, épreuves, examens et corrections.<br>
            Utilisez la barre de navigation en haut pour accéder à chaque section.<br>
            Vous pouvez ajouter, modifier ou supprimer des enregistrements pour chaque table.<br>
            <br>
            <strong>Comment naviguer ?</strong><br>
            Cliquez sur un onglet dans la barre pour afficher la liste des éléments, puis utilisez les boutons d'action pour gérer les données.<br>
            <br>
            Commencez par explorer les professeurs ou les corrections via les liens ci-dessous !
        </div>
        <div class="actions">
            <a href="src/views/Professeur/index.php">Voir les professeurs</a>
            <a href="src/views/Correction/index.php">Voir les corrections</a>
        </div>
    </div>

    <?php
    $footer = new Footer();
    $footer->render(); ?>
    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
