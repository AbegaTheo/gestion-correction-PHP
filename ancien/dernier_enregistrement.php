<?php
require_once __DIR__ . '/../inclure/navbar.php';
include __DIR__ . '/../config/connect_db.php';
?>

<?php

// Récupère le dernier enregistrement
$stmt = $conn->query("
    SELECT c.*, p.nom AS nom_prof, p.prenom AS prenom_prof, p.grade, e.nom_epreuve, e.type_epreuve, ex.nom_exam, et.nom_etab, et.ville
    FROM corriger c
    JOIN Professeur p ON c.matricule = p.matricule
    JOIN Epreuve e ON c.nom_epreuve = e.nom_epreuve
    JOIN Examen ex ON e.code_exam = ex.code_exam
    JOIN Etablissement et ON p.code_etab = et.code_etab
    ORDER BY c.date_correction DESC, c.matricule DESC
    LIMIT 1
");
$correction = $stmt->fetch_assoc();
?>

<title>Dernier enregistrement - Fiche de Correction</title>
<style>
    .form-label {
        font-weight: 600;
    }
</style>

<h2 class="mb-4 d-flex justify-content-center text-center">Dernière fiche de correction enregistrée</h2>
<?php if ($correction): ?>
    <div class="container mt-4">
        <form class="shadow p-4 bg-white rounded" style="margin:auto;">
            <!-- Professeur & Établissement -->
            <fieldset class="mb-4 border border-2 border-primary rounded p-3">
                <legend class="float-none w-auto px-3 fw-bold text-primary">Professeur & Établissement</legend>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Nom</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($correction['nom_prof']) ?>" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Prénom</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($correction['prenom_prof']) ?>" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Grade</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($correction['grade']) ?>" readonly>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <label class="form-label">Nom établissement</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($correction['nom_etab']) ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Ville</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($correction['ville']) ?>" readonly>
                    </div>
                </div>
            </fieldset>

            <!-- Examen & Épreuve -->
            <fieldset class="mb-4 border border-2 border-warning rounded p-3">
                <legend class="float-none w-auto px-3 fw-bold text-warning">Examen & Épreuve</legend>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nom de l’examen</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($correction['nom_exam']) ?>" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Nom de l’épreuve</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($correction['nom_epreuve']) ?>" readonly>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Type d’épreuve</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($correction['type_epreuve']) ?>" readonly>
                    </div>
                </div>
            </fieldset>

            <!-- Correction -->
            <fieldset class="mb-4 border border-2 border-danger rounded p-3">
                <legend class="float-none w-auto px-3 fw-bold text-danger">Correction</legend>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Date de correction</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($correction['date_correction']) ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nombre de copies / candidats</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($correction['nbre_copie']) ?>" readonly>
                    </div>
                </div>
            </fieldset>

            <div class="text-end">
                <a href="modifier.php?id=<?= $correction['matricule'] ?>&epreuve=<?= urlencode($correction['nom_epreuve']) ?>&date=<?= urlencode($correction['date_correction']) ?>" class="btn btn-warning">Modifier</a>
                <a href="supprimer.php?id=<?= $correction['matricule'] ?>&epreuve=<?= urlencode($correction['nom_epreuve']) ?>&date=<?= urlencode($correction['date_correction']) ?>" class="btn btn-danger" onclick="return confirm('Supprimer cette correction ?');">Supprimer</a>
                <a href="formulaire_correction.php" class="btn btn-primary">Ajouter une nouvelle correction</a>
            </div>
        </form>
    </div>
<?php else: ?>
    <div class="alert alert-info text-center mt-5">Aucune correction enregistrée pour le moment.</div>
    <div class="text-center"><a href="formulaire_correction.php" class="btn btn-primary">Ajouter une nouvelle correction</a></div>
<?php endif; ?>