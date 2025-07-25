<?php
require_once "inclure/navbar.php";
?>

<!DOCTYPE html>
<html lang="fr-FR">

<head>
    <meta charset="UTF-8">
    <title>Accueil - Fiche Correction</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(120deg, #f8fafc 0%, #e3eafc 100%);
            min-height: 100vh;
        }
        .container {
            margin: 60px auto;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            background: #fff;
            padding: 40px 32px;
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        }
        h1 {
            margin-bottom: 24px;
            font-size: 2.5rem;
            font-weight: 700;
            color: #0d6efd;
            text-align: center;
        }
        .lead {
            font-size: 1.2rem;
            color: #333;
            text-align: center;
            margin-bottom: 32px;
        }
        .btn-group {
            display: flex;
            justify-content: center;
            gap: 24px;
            margin-top: 30px;
        }
        .btn-lg {
            padding: 5px 15px;
            font-size: 1.2rem;
            border-radius: 8px;
        }
        .icon {
            font-size: 2.2rem;
            vertical-align: middle;
            margin-right: 8px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1><span class="icon">📋</span>Gestion des fiches de correction</h1>
        <p class="lead">
            Bienvenue !<br>
            Utilisez le menu ci-dessous pour ajouter ou consulter vos corrections.
        </p>
        <div class="btn-group">
            <a href="/gestion-correction/controllers/formulaire_correction.php" class="btn btn-primary btn-lg">
                <span class="icon">➕</span>Ajouter une correction
            </a>
            <a href="/gestion-correction/controllers/liste_tables.php" class="btn btn-outline-primary btn-lg">
                <span class="icon">📑</span>Liste des tables
            </a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>