<?php
// Inclure l'autoloader
require_once __DIR__ . '/../../../autoload.php';

use App\Controllers\EtablissementController;
use App\Models\Etablissement;
use App\Views\Layout\Header;
use App\Views\Layout\Footer;

$header = new Header();
$header->render();
$footer = new Footer();

// Initialisation du Etablissement (nouveau ou existant)
$isEditMode = isset($_GET['id']);
$etab = new Etablissement();
$etablissementController = new EtablissementController();

if ($isEditMode) {
    // Mode édition
    $id = (int)$_GET['id'];
    // Récupérer l'établissement existant (à implémenter)
    $etab = $etablissementController->find($id);

    if (!$etab) {
        header('Location: index.php?error=not_found');
        exit;
    }

    if (isset($_POST['submit'])) {
        // Traitement du formulaire de modification
        $etab->setNom($_POST['nom']);
        $etab->setVille($_POST['ville']);

        $etab = $etablissementController->edit($id, $etab);
        // Redirection après modification
        header('Location: index.php?success=edit');
        exit;
    }
} else {
    // Mode création
    if (isset($_POST['submit'])) {
        // Traitement du formulaire d'ajout
        $etab = new Etablissement(
            $_POST['nom'],
            $_POST['ville']
        );

        $etablissementController->new($etab);
        // Redirection après ajout
        header('Location: index.php?success=add');
        exit;
    }
}
?>
<!-- Formulaire pour créer et modifier un professeur -->
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($_GET['id']) ? 'Modifier' : 'Ajouter' ?> un etablissement - Gestion de correction</title>
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
</head>

<body>
    <!-- En-tête descriptif -->
    <div class="header-section">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h1 class="page-title">
                        <?= $isEditMode ? '<i class="fas fa-edit"></i> Modifier un etablissement' : '<i class="fas fa-plus-circle"></i> Ajouter un etablissement' ?>
                    </h1>
                    <p class="page-description">
                        <?= $isEditMode ? "Modifiez les informations de l'etablissement existant." : "Remplissez le formulaire ci-dessous pour ajouter un nouvel etablissement au système." ?>
                        Tous les champs marqués d'un astérisque (*) sont obligatoires.
                    </p>
                </div>
                <div class="col-md-4 d-flex align-items-center justify-content-end">
                    <a href="index.php" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Retour à la liste
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="form-container">
            <form id="etabForm" action="" method="post" class="needs-validation" novalidate>
                <?php if ($isEditMode): ?>
                    <input type="hidden" name="id" value="<?= $etab->getId() ?>">
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nom" id="nom" value="<?= $etab->getNom() ?>" required>
                        <div class="invalid-feedback">Veuillez saisir un nom pour l'etablissement.</div>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="ville" class="form-label">Ville <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="ville" id="ville" value="<?= $etab->getVille() ?>" required>
                        <div class="invalid-feedback">Veuillez saisir une ville.</div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="index.php" class="btn btn-outline-secondary btn-action">
                        <i class="fas fa-times"></i> Annuler
                    </a>
                    <button type="button" id="confirmBtn" class="btn btn-primary btn-action">
                        <i class="fas fa-save"></i> <?= $isEditMode ? 'Enregistrer' : 'Ajouter' ?>
                    </button>
                    <!-- Bouton de soumission caché qui sera déclenché après confirmation -->
                    <button type="submit" name="submit" id="submitBtn" class="d-none">Soumettre</button>
                </div>
            </form>
        </div>

        <!-- Aide contextuelle -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-info-circle me-2"></i> Informations
            </div>
            <div class="card-body">
                <h5 class="card-title">Aide pour remplir le formulaire</h5>
                <ul>
                    <li><strong>Nom</strong> : Entrez le nom de l'etablissement.</li>
                    <li><strong>Ville</strong> : Entrez la ville où se situe l'etablissement.</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Modal de confirmation -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">
                        <i class="fas fa-check-circle text-primary me-2"></i>
                        Confirmation
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <p>Veuillez confirmer les informations suivantes :</p>

                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-4">Nom :</div>
                                <div class="col-8 confirmation-value" id="confirm-nom"></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4">Ville :</div>
                                <div class="col-8 confirmation-value" id="confirm-ville"></div>
                            </div>
                        </div>
                    </div>

                    <p class="text-center">
                        Êtes-vous sûr de vouloir <?= $isEditMode ? 'modifier' : 'ajouter' ?> cet etablissement ?
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Annuler
                    </button>
                    <button type="button" class="btn btn-primary" id="modalConfirmBtn">
                        <i class="fas fa-check"></i> Confirmer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php $footer->render(); ?>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Validation du formulaire et confirmation -->
    <script>
        // Validation du formulaire
        (function() {
            'use strict';

            // Récupérer tous les formulaires auxquels nous voulons appliquer des styles de validation Bootstrap personnalisés
            var forms = document.querySelectorAll('.needs-validation');

            // Boucle pour empêcher la soumission et appliquer la validation
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }

                    form.classList.add('was-validated');
                }, false);
            });
        })();

        // Gestion de la confirmation
        document.addEventListener('DOMContentLoaded', function() {
            // Éléments du DOM
            const form = document.getElementById('etabForm');
            const confirmBtn = document.getElementById('confirmBtn');
            const submitBtn = document.getElementById('submitBtn');
            const modalConfirmBtn = document.getElementById('modalConfirmBtn');
            const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));

            // Champs du formulaire
            const nomInput = document.getElementById('nom');
            const villeInput = document.getElementById('ville');

            // Éléments de confirmation dans le modal
            const confirmNom = document.getElementById('confirm-nom');
            const confirmVille = document.getElementById('confirm-ville');

            // Afficher le modal de confirmation lorsque l'utilisateur clique sur le bouton d'ajout/modification
            confirmBtn.addEventListener('click', function() {
                // Vérifier d'abord la validité du formulaire
                if (!form.checkValidity()) {
                    form.classList.add('was-validated');
                    return;
                }

                // Remplir le modal avec les valeurs du formulaire
                confirmNom.textContent = nomInput.value;
                confirmVille.textContent = villeInput.value;

                // Afficher le modal
                confirmationModal.show();
            });

            // Soumettre le formulaire lorsque l'utilisateur confirme
            modalConfirmBtn.addEventListener('click', function() {
                confirmationModal.hide();
                submitBtn.click(); // Déclencher le bouton de soumission caché
            });
        });
    </script>
</body>

</html>
