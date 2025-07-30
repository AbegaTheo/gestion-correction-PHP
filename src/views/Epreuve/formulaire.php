<?php
// Inclure l'autoloader
require_once __DIR__ . '/../../../autoload.php';

use App\Controllers\EpreuveController;
use App\Models\Epreuve;
use App\Views\Layout\Header;
use App\Views\Layout\Footer;

$header = new Header();
$header->render();
$footer = new Footer();

// Initialisation de l'épreuve (nouvelle ou existante)
$isEditMode = isset($_GET['id']);
$epreuve = new Epreuve();
$epreuveController = new EpreuveController();

if ($isEditMode) {
    // Mode édition
    $id = (int)$_GET['id'];
    // Récupérer l'épreuve existante (à implémenter)
    $epreuve = $epreuveController->find($id);

    if (!$epreuve) {
        header('Location: index.php?error=not_found');
        exit;
    }

    if (isset($_POST['submit'])) {
        // Traitement du formulaire de modification
        $epreuve->setNom($_POST['nom']);
        $epreuve->setType($_POST['type']);
        $epreuve->setIdExamen($_POST['id_examen']);

        $epreuve = $epreuveController->edit($id, $epreuve);
        // Redirection après modification
        header('Location: index.php?success=edit');
        exit;
    }
} else {
    // Mode création
    if (isset($_POST['submit'])) {
        // Traitement du formulaire d'ajout
        $epreuve = new Epreuve(
            $_POST['nom'],
            $_POST['type'],
            $_POST['id_examen']
        );

        $epreuve = $epreuveController->new($epreuve);
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
    <title><?= isset($_GET['id']) ? 'Modifier' : 'Ajouter' ?> une épreuve - Gestion de correction</title>
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
                        <?= $isEditMode ? '<i class="fas fa-edit"></i> Modifier une épreuve' : '<i class="fas fa-plus-circle"></i> Ajouter une épreuve' ?>
                    </h1>
                    <p class="page-description">
                        <?= $isEditMode ? "Modifiez les informations de l'épreuve existante." : "Remplissez le formulaire ci-dessous pour ajouter une nouvelle épreuve au système." ?>
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
            <form id="epreuveForm" action="" method="post" class="needs-validation" novalidate>
                <?php if ($isEditMode): ?>
                    <input type="hidden" name="id" value="<?= $epreuve->getId() ?>">
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="nom" class="form-label">Nom de l'épreuve <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nom" id="nom" value="<?= $epreuve->getNom() ?>" required>
                        <div class="invalid-feedback">Veuillez saisir un nom.</div>
                    </div>

                    <div class="col-md-3 form-group">
                        <label for="type" class="form-label">Type de l'épreuve <span class="text-danger">*</span></label>
                        <select class="form-select" name="type" id="type" required>
                            <option value="" disabled <?= empty($epreuve->getType()) ? 'selected' : '' ?>>Sélectionnez un type</option>
                            <option value="Ecrit" <?= $epreuve->getType() === 'Ecrit' ? 'selected' : '' ?>>Ecrit</option>
                            <option value="Oral" <?= $epreuve->getType() === 'Oral' ? 'selected' : '' ?>>Oral</option>
                        </select>
                        <div class="invalid-feedback">Veuillez sélectionner un type d'épreuve.</div>
                    </div>

                    <div class="col-md-5 form-group">
                        <label for="id_examen" class="form-label">Examen <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="id_examen" id="id_examen" value="<?= $epreuve->getIdExamen() ?>" required>
                        <div class="invalid-feedback">Veuillez saisir un ID d'examen valide.</div>
                        <small class="form-text text-muted">Entrez l'identifiant de l'examen auquel cette épreuve est rattachée.</small>
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
                    <li><strong>Nom</strong> : Entrez le nom de l'épreuve.</li>
                    <li><strong>Type de l'épreuve</strong> : Sélectionnez le type de l'épreuve (Écrit ou Oral).</li>
                    <li><strong>Examen</strong> : Entrez l'identifiant numérique de l'examen auquel cette épreuve est rattachée.</li>
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
                                <div class="col-4">Nom de l'épreuve :</div>
                                <div class="col-8 confirmation-value" id="confirm-nom"></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4">Examen :</div>
                                <div class="col-8 confirmation-value" id="confirm-id_examen"></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4">Type de l'épreuve :</div>
                                <div class="col-8 confirmation-value" id="confirm-type"></div>
                            </div>
                        </div>
                    </div>

                    <p class="text-center">
                        Êtes-vous sûr de vouloir <?= $isEditMode ? 'modifier' : 'ajouter' ?> cette épreuve ?
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
            const form = document.getElementById('epreuveForm');
            const confirmBtn = document.getElementById('confirmBtn');
            const submitBtn = document.getElementById('submitBtn');
            const modalConfirmBtn = document.getElementById('modalConfirmBtn');
            const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));

            // Champs du formulaire
            const nomInput = document.getElementById('nom');
            const examenInput = document.getElementById('id_examen');
            const typeSelect = document.getElementById('type');
            
            // Éléments de confirmation dans le modal
            const confirmNom = document.getElementById('confirm-nom');
            const confirmExamen = document.getElementById('confirm-id_examen');
            const confirmType = document.getElementById('confirm-type');

            // Afficher le modal de confirmation lorsque l'utilisateur clique sur le bouton d'ajout/modification
            confirmBtn.addEventListener('click', function() {
                // Vérifier d'abord la validité du formulaire
                if (!form.checkValidity()) {
                    form.classList.add('was-validated');
                    return;
                }

                // Remplir le modal avec les valeurs du formulaire
                confirmNom.textContent = nomInput.value;
                confirmExamen.textContent = examenInput.value;
                confirmType.textContent = typeSelect.options[typeSelect.selectedIndex].text;

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
