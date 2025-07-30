<?php
// Inclure l'autoloader
require_once __DIR__ . '/../../../autoload.php';

use App\Controllers\EpreuveController;
use App\Views\Layout\Header;
use App\Views\Layout\Footer;

// Charger les épreuves depuis le contrôleur
$epreuveController = new EpreuveController();
$epreuves = $epreuveController->index();
$totalEpreuves = count($epreuves);

$header = new Header();
$header->render();
$footer = new Footer();
?>
<!-- index.php : Pour lister les enregistrements de la table Epreuve -->
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Epreuves - Système de Gestion de Correction</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .table-container {
            margin-top: 2rem;
            margin-bottom: 2rem;
        }

        .actions-btn {
            margin-right: 5px;
        }

        .page-title {
            margin-bottom: 0.5rem;
            color: #0d6efd;
        }

        .page-description {
            margin-bottom: 1.5rem;
            color: #6c757d;
        }

        .header-section {
            background-color: #f8f9fa;
            padding: 2rem 0;
            margin-bottom: 2rem;
            border-bottom: 1px solid #e9ecef;
        }

        .add-btn {
            margin-bottom: 1.5rem;
        }

        footer {
            margin-top: 3rem;
            padding: 1rem 0;
            background-color: #f8f9fa;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }

        .count-badge {
            font-size: 1rem;
            background-color: #0d6efd;
            color: white;
            padding: 0.3rem 0.7rem;
            border-radius: 50px;
            margin-left: 10px;
            display: inline-block;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
    <!-- En-tête descriptif -->
    <div class="header-section">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h1 class="page-title">
                        Gestion des Epreuves

                        <span class="count-badge" title="Nombre total d'épreuves">
                            <i class="fas fa-file-alt"></i> <?= $totalEpreuves ?>
                        </span>
                    </h1>
                    <p class="page-description">
                        Cette interface vous permet de consulter, ajouter, modifier et supprimer les informations des épreuves
                        impliquées dans le processus de correction des examens. Chaque épreuve est associée à un examen spécifique.
                        <!-- Vous pouvez également rechercher des épreuves par leur nom ou par leur examen. -->
                    </p>
                </div>
                <div class="col-md-4 d-flex align-items-center justify-content-end">
                    <div class="text-end">
                        <a href="formulaire.php" class="btn btn-primary">
                            <i class="fas fa-plus-circle"></i> Ajouter une épreuve
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <?php if (isset($_GET['success']) && $_GET['success'] === 'delete'): ?>
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                <i class="fas fa-check-circle me-2"></i> L'épreuve a été supprimé avec succès.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
        <?php endif; ?>
        <div class="table-container">
            <div class="table-header">
                <h3>Liste des épreuves <small class="text-muted">(<?= $totalEpreuves ?> au total)</small></h3>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Type épreuve</th>
                            <th>Examen</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($totalEpreuves > 0): ?>
                            <?php foreach ($epreuves as $epreuve): ?>
                                <tr>
                                    <td><?= $epreuve->getId() ?></td>
                                    <td><?= $epreuve->getNom() ?></td>
                                    <td><?= $epreuve->getType() ?></td>
                                    <td><?= $epreuve->getIdExamen() ?></td>
                                    <td>
                                        <a href="formulaire.php?id=<?= $epreuve->getId() ?>" class="btn btn-sm btn-outline-primary actions-btn">
                                            <i class="fas fa-edit"></i> Modifier
                                        </a>
                                        <a href="supprimer.php?id=<?= $epreuve->getId() ?>" class="btn btn-sm btn-outline-danger actions-btn">
                                            <i class="fas fa-trash-alt"></i> Supprimer
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">
                                    <div class="alert alert-info my-3">
                                        <i class="fas fa-info-circle me-2"></i> Aucune épreuve n'est enregistrée dans le système.
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Résumé statistique -->
        <div class="card mb-4">
            <div class="card-header bg-light">
                <i class="fas fa-chart-bar me-2"></i> Statistiques
            </div>
            <div class="card-body">
                <div class="row text-center d-flex justify-content-center">
                    <div class="col-md-4">
                        <div class="h1 mb-0"><?= $totalEpreuves ?></div>
                        <div class="small text-muted">Epreuves enregistrées</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Légende des actions -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-info-circle me-2"></i> Informations
            </div>
            <div class="card-body">
                <p class="card-text">
                    <strong>Actions disponibles :</strong>
                <ul>
                    <li><strong>Modifier</strong> : Permet de mettre à jour les informations d'une épreuve</li>
                    <li><strong>Supprimer</strong> : Permet de retirer une épreuve du système (cette action est irréversible)</li>
                </ul>
                </p>
            </div>
        </div>
    </div>

    <?php $footer->render(); ?>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
