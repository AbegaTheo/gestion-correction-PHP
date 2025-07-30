<?php
// Inclure l'autoloader
require_once __DIR__ . '/../../../autoload.php';

use App\Controllers\CorrectionController;
use App\Models\Correction;
use App\Views\Layout\Header;
use App\Views\Layout\Footer;

$header = new Header();
$header->render();
$footer = new Footer();

// Initialisation de la correction (nouvelle ou existante)
$isEditMode = isset($_GET['id']);
$correction = new Correction();
$correctionController = new CorrectionController();

if ($isEditMode) {
    // Mode édition
    $id = (int)$_GET['id'];
    // Récupérer la correction existante (à implémenter)
    $correction = $correctionController->find($id);

    if (!$correction) {
        header('Location: index.php?error=not_found');
        exit;
    }

    if (isset($_POST['submit'])) {
        // Traitement du formulaire de modification
        $correction->setIdProfesseur($_POST['id_professeur']);
        $correction->setIdEpreuve($_POST['id_epreuve']);
        $correction->setDate($_POST['date']);
        $correction->setNbrCopie($_POST['nbr_copie']);

        $correction = $correctionController->edit($id, $correction);
        // Redirection après modification
        header('Location: index.php?success=edit');
        exit;
    }
} else {
    // Mode création
    if (isset($_POST['submit'])) {
        // Traitement du formulaire d'ajout
        $correction = new Correction(
            $_POST['id_professeur'],
            $_POST['id_epreuve'],
            $_POST['date'],
            $_POST['nbr_copie']
        );

        $correction = $correctionController->new($correction);
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
    <title><?= isset($_GET['id']) ? 'Modifier' : 'Ajouter' ?> une correction - Gestion de correction</title>
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
                        <?= $isEditMode ? '<i class="fas fa-edit"></i> Modifier une correction' : '<i class="fas fa-plus-circle"></i> Ajouter une correction' ?>
                    </h1>
                    <p class="page-description">
                        <?= $isEditMode ? 'Modifiez les informations de la correction existante.' : 'Remplissez le formulaire ci-dessous pour ajouter une nouvelle correction au système.' ?>
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
            <form id="correctionForm" action="" method="post" class="needs-validation" novalidate>
                <?php if ($isEditMode): ?>
                    <input type="hidden" name="id" value="<?= $correction->getId() ?>">
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="id_professeur" class="form-label">ID du professeur <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="id_professeur" id="id_professeur" value="<?= $correction->getIdProfesseur() ?>" required>
                        <div class="invalid-feedback">Veuillez saisir un ID valide.</div>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="id_epreuve" class="form-label">ID de l'épreuve <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="id_epreuve" id="id_epreuve" value="<?= $correction->getIdEpreuve() ?>" required>
                        <div class="invalid-feedback">Veuillez saisir un ID valide.</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="date" class="form-label">Date de correction <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="date" id="date" value="<?= $correction->getDate() ?>" required>
                        <div class="invalid-feedback">Veuillez sélectionner une date valide.</div>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="nbr_copie" class="form-label">Nombre de copies corrigées <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="nbr_copie" id="nbr_copie" value="<?= $correction->getNbrCopie() ?>" required>
                        <div class="invalid-feedback">Veuillez saisir un nombre valide.</div>
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
                    <li><strong>ID du professeur</strong> : Entrez l'identifiant du professeur responsable de la correction.</li>
                    <li><strong>ID de l'épreuve</strong> : Entrez l'identifiant de l'épreuve concernée par la correction.</li>
                    <li><strong>Date de correction</strong> : Sélectionnez la date à laquelle la correction a été effectuée.</li>
                    <li><strong>Nombre de copies corrigées</strong> : Indiquez le nombre de copies qui ont été corrigées.</li>
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
                                <div class="col-4">ID du professeur :</div>
                                <div class="col-8 confirmation-value" id="confirm-id_prof"></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4">ID de l'épreuve :</div>
                                <div class="col-8 confirmation-value" id="confirm-id_epreuve"></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4">Date de correction :</div>
                                <div class="col-8 confirmation-value" id="confirm-date"></div>
                            </div>
                            <div class="row">
                                <div class="col-4">Nombre de copies corrigées :</div>
                                <div class="col-8 confirmation-value" id="confirm-nbr_copie"></div>
                            </div>
                        </div>
                    </div>

                    <p class="text-center">
                        Êtes-vous sûr de vouloir <?= $isEditMode ? 'modifier' : 'ajouter' ?> cette correction ?
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
            const form = document.getElementById('correctionForm');
            const confirmBtn = document.getElementById('confirmBtn');
            const submitBtn = document.getElementById('submitBtn');
            const modalConfirmBtn = document.getElementById('modalConfirmBtn');
            const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));

            // Champs du formulaire
            const idProfInput = document.getElementById('id_professeur');
            const idEpreuveInput = document.getElementById('id_epreuve');
            const dateInput = document.getElementById('date');
            const nbrCopieInput = document.getElementById('nbr_copie');

            // Éléments de confirmation dans le modal
            const confirmIdProf = document.getElementById('confirm-id_prof');
            const confirmIdEpreuve = document.getElementById('confirm-id_epreuve');
            const confirmDate = document.getElementById('confirm-date');
            const confirmNbrCopie = document.getElementById('confirm-nbr_copie');

            // Afficher le modal de confirmation lorsque l'utilisateur clique sur le bouton d'ajout/modification
            confirmBtn.addEventListener('click', function() {
                // Vérifier d'abord la validité du formulaire
                if (!form.checkValidity()) {
                    form.classList.add('was-validated');
                    return;
                }

                // Remplir le modal avec les valeurs du formulaire
                confirmIdProf.textContent = idProfInput.value;
                confirmIdEpreuve.textContent = idEpreuveInput.value;
                confirmDate.textContent = dateInput.value;
                confirmNbrCopie.textContent = nbrCopieInput.value;

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
