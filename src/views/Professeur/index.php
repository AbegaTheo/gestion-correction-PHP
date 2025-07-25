<?php
// Inclure l'autoloader
require_once __DIR__ . '/../../../autoload.php';
?>
<!-- index.php : Pour lister les enregistrements de la table Professeur -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professeurs - Système de Gestion de Correction</title>
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

<?php
use App\Controllers\ProfesseurController;
use App\Views\Layout\Header;
use App\Views\Layout\Footer;

// Charger les professeurs depuis le contrôleur
$professeurController = new ProfesseurController();
$professeurs = $professeurController->index();
$totalProfesseurs = count($professeurs);

$header = new Header();
$header->render();
?>

<!-- En-tête descriptif -->
<div class="header-section">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1 class="page-title">
                    Gestion des Professeurs
                    <span class="count-badge" title="Nombre total de professeurs">
                        <i class="fas fa-users"></i> <?= $totalProfesseurs ?>
                    </span>
                </h1>
                <p class="page-description">
                    Cette interface vous permet de consulter, ajouter, modifier et supprimer les informations des professeurs
                    impliqués dans le processus de correction des examens. Chaque professeur est associé à un établissement
                    et possède un grade spécifique.
                </p>
            </div>
            <div class="col-md-4 d-flex align-items-center justify-content-end">
                <div class="text-end">
                    <a href="formulaire.php" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i> Ajouter un professeur
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <?php if (isset($_GET['success']) && $_GET['success'] === 'delete'): ?>
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            <i class="fas fa-check-circle me-2"></i> Le professeur a été supprimé avec succès.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    <?php endif; ?>
    <div class="table-container">
        <div class="table-header">
            <h3>Liste des professeurs <small class="text-muted">(<?= $totalProfesseurs ?> au total)</small></h3>
        </div>
        
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Grade</th>
                        <th>Établissement</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($totalProfesseurs > 0): ?>
                        <?php foreach ($professeurs as $prof): ?>
                        <tr>
                            <td><?= $prof->getId() ?></td>
                            <td><?= $prof->getNom() ?></td>
                            <td><?= $prof->getPrenom() ?></td>
                            <td><?= $prof->getGrade() ?></td>
                            <td><?= $prof->getIdEtab() ?></td>
                            <td>
                                <a href="formulaire.php?id=<?= $prof->getId() ?>" class="btn btn-sm btn-outline-primary actions-btn">
                                    <i class="fas fa-edit"></i> Modifier
                                </a>
                                <a href="supprimer.php?id=<?= $prof->getId() ?>" class="btn btn-sm btn-outline-danger actions-btn">
                                    <i class="fas fa-trash-alt"></i> Supprimer
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">
                                <div class="alert alert-info my-3">
                                    <i class="fas fa-info-circle me-2"></i> Aucun professeur n'est enregistré dans le système.
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
            <div class="row text-center">
                <div class="col-md-4">
                    <div class="h1 mb-0"><?= $totalProfesseurs ?></div>
                    <div class="small text-muted">Professeurs enregistrés</div>
                </div>
                <?php if ($totalProfesseurs > 0): ?>
                <div class="col-md-8">
                    <div class="progress mt-3" style="height: 25px;">
                        <div class="progress mt-3" style="height: 25px;">
                            <progress value="<?= $totalProfesseurs ?>" max="<?= $totalProfesseurs ?>"></progress>
                            <span><?= $totalProfesseurs ?> professeurs</span>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
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
                    <li><strong>Modifier</strong> : Permet de mettre à jour les informations d'un professeur</li>
                    <li><strong>Supprimer</strong> : Permet de retirer un professeur du système (cette action est irréversible)</li>
                </ul>
            </p>
        </div>
    </div>
</div>

<?php
$footer = new Footer();
$footer->render(); ?>

<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
