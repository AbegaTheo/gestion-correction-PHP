<?php
// Inclure l'autoloader
require_once __DIR__ . '/../../../autoload.php';

use App\Controllers\EtablissementController;
use App\Views\Layout\Header;
use App\Views\Layout\Footer;

// Vérifier si un ID est fourni
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Aucun ID fourni, afficher un message d'erreur
    $error = "Aucun etablissement spécifié pour la suppression.";
    $showConfirmation = false;
} else {
    $id = (int)$_GET['id'];
    $showConfirmation = true;

    // Si la confirmation est donnée, procéder à la suppression
    if (isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
        $etablissementController = new EtablissementController();
        $success = $etablissementController->delete($id);

        if ($success) {
            // Redirection avec message de succès
            header('Location: index.php?success=delete');
            exit;
        } else {
            // Échec de la suppression
            $error = "Erreur lors de la suppression de l'etablissement. Veuillez réessayer.";
            $showConfirmation = false;
        }
    }
}

$header = new Header();
$header->render();
$footer = new Footer();
?>

    <title>Supprimer un etablissement - Gestion de correction</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .header-section {
            background-color: #f8f9fa;
            padding: 2rem 0;
            margin-bottom: 2rem;
            border-bottom: 1px solid #e9ecef;
        }

        .page-title {
            margin-bottom: 0.5rem;
            color: #0d6efd;
        }

        .page-description {
            margin-bottom: 1.5rem;
            color: #6c757d;
        }

        .form-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .btn-action {
            min-width: 120px;
        }

        footer {
            margin-top: 3rem;
            padding: 1rem 0;
            background-color: #f8f9fa;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }

        .confirmation-value {
            font-weight: bold;
        }
    </style>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h4><i class="fas fa-trash-alt me-2"></i> Suppression d'un etablissement</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle me-2"></i> <?= $error ?>
                        </div>
                        <a href="index.php" class="btn btn-primary">
                            <i class="fas fa-arrow-left me-2"></i> Retour à la liste
                        </a>
                    <?php elseif ($showConfirmation): ?>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i> Attention : Cette action est irréversible !
                        </div>
                        <p class="lead">Êtes-vous sûr de vouloir supprimer cet etablissement ?</p>
                        <p>Une fois supprimé, toutes les données associées à cet etablissement seront définitivement perdues.</p>

                        <form action="supprimer.php?id=<?= $id ?>" method="post" class="mt-4">
                            <div class="d-flex gap-3">
                                <button type="submit" name="confirm" value="yes" class="btn btn-danger">
                                    <i class="fas fa-trash-alt me-2"></i> Oui, supprimer
                                </button>
                                <a href="index.php" class="btn btn-secondary">
                                    <i class="fas fa-times me-2"></i> Non, annuler
                                </a>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $footer->render(); ?>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
