<?php
// Inclure l'autoloader
require_once __DIR__ . '/../../../autoload.php';
?>
<!-- index.php : Pour lister les enregistrements de la table Etablissement -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etablissements - Gestion de Correction</title>
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
use App\Controllers\EtablissementController;
use App\Views\Layout\Header;
use App\Views\Layout\Footer;

// Charger les Etablissements depuis le contrôleur
$etabController = new EtablissementController();
$etabs = $etabController->index();
$totalEtabs = count($etabs);

$header = new Header();
$header->render();
?>

<!-- En-tête descriptif -->
<div class="header-section">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1 class="page-title">
                    Gestion des Etablissments
                    <span class="count-badge" title="Nombre total des Etablissements">
                        <i class="fas fa-school"></i> <?= $totalEtabs ?>
                    </span>
                </h1>
                <p class="page-description">
                    Cette interface vous permet de consulter, ajouter, modifier et supprimer les informations des etablissements
                    impliqués dans le processus de correction des examens. Chaque professeur est associé à un établissement
                    et possède un grade spécifique.
                </p>
            </div>
            <div class="col-md-4 d-flex align-items-center justify-content-end">
                <div class="text-end">
                    <a href="formulaire.php" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i> Ajouter un nouvel etablissement
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <?php if (isset($_GET['success']) && $_GET['success'] === 'delete'): ?>
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            <i class="fas fa-check-circle me-2"></i> L'Etablissement a été supprimé avec succès.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    <?php endif; ?>
    <div class="table-container">
        <div class="table-header">
            <h3>Liste des etablissements <small class="text-muted">(<?= $totalEtabs ?> au total)</small></h3>
        </div>
        
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Ville</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($totalEtabs > 0): ?>
                        <?php foreach ($etabs as $etab): ?>
                        <tr>
                            <td><?= $etab->getId() ?></td>
                            <td><?= $etab->getNom() ?></td>
                            <td><?= $etab->getVille() ?></td>
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
                                    <i class="fas fa-info-circle me-2"></i> Aucun etablissement n'est enregistré dans le système.
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
                    <div class="h1 mb-0"><?= $totalEtabs ?></div>
                    <div class="small text-muted">Etablisements enregistrés</div>
                </div>
                <?php if ($totalEtabs > 0): ?>
                <div class="col-md-8">
                    <div class="progress mt-3" style="height: 25px;">
                        <div class="progress mt-3" style="height: 25px;">
                            <progress value="<?= $totalEtabs ?>" max="<?= $totalEtabs ?>"></progress>
                            <span><?= $totalEtabs ?> etablissements</span>
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
                    <li><strong>Modifier</strong> : Permet de mettre à jour les informations d'un etablissement</li>
                    <li><strong>Supprimer</strong> : Permet de retirer un etablissement du système (cette action est irréversible)</li>
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
