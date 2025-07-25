<?php
include __DIR__ . '/../config/connect_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $nom_etab = $_POST['nom_etab'];
    $ville = $_POST['ville'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $grade = $_POST['grade'];
    $nom_exam = $_POST['nom_exam'];
    $nom_epreuve = $_POST['nom_epreuve'];
    $type_epreuve = $_POST['type_epreuve'];
    $date_correction = $_POST['date_correction'];
    $nbre_copie = intval($_POST['nbre_copie']);

    // 1. Vérifier ou insérer l'établissement
    $stmt = $conn->prepare("SELECT code_etab FROM ETABLISSEMENT WHERE nom_etab=? AND ville=?");
    $stmt->bind_param("ss", $nom_etab, $ville);
    $stmt->execute();
    $stmt->bind_result($code_etab);
    if (!$stmt->fetch()) {
        $stmt->close();
        $stmt = $conn->prepare("INSERT INTO ETABLISSEMENT (nom_etab, ville) VALUES (?, ?)");
        $stmt->bind_param("ss", $nom_etab, $ville);
        $stmt->execute();
        $code_etab = $conn->insert_id;
    }
    $stmt->close();

    // 2. Vérifier ou insérer le professeur
  /*   $stmt = $conn->prepare("SELECT matricule FROM PROFESSEUR WHERE nom=:nom AND prenom=:prenom AND grade=:grade AND code_etab=:code_etab");
    $stmt->bind_param(":nom", $nom, ":prenom", $prenom, ":grade", $grade, ":code_etab", $code_etab);
    $stmt->execute();
    $stmt->bind_result($matricule);
    if (!$stmt->fetch()) {
        $stmt->close(); */
        $stmt = $conn->prepare("INSERT INTO PROFESSEUR (nom, prenom, grade, code_etab) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $nom, $prenom, $grade, $code_etab);
        $stmt->execute();
        $matricule = $conn->insert_id;
 /*    
    $stmt->close(); */

    // 3. Vérifier ou insérer l'examen
    $stmt = $conn->prepare("SELECT code_exam FROM EXAMEN WHERE nom_exam=?");
    $stmt->bind_param("s", $nom_exam);
    $stmt->execute();
    $stmt->bind_result($code_exam);
    if (!$stmt->fetch()) {
        $stmt->close();
        $stmt = $conn->prepare("INSERT INTO EXAMEN (nom_exam) VALUES (?)");
        $stmt->bind_param("s", $nom_exam);
        $stmt->execute();
        $code_exam = $conn->insert_id;
    }
    $stmt->close();

    // 4. Vérifier ou insérer l'épreuve
    $stmt = $conn->prepare("SELECT nom_epreuve FROM EPREUVE WHERE nom_epreuve=? AND code_exam=?");
    $stmt->bind_param("si", $nom_epreuve, $code_exam);
    $stmt->execute();
    $stmt->bind_result($nom_epreuve);
    if (!$stmt->fetch()) {
        $stmt->close();
        $stmt = $conn->prepare("INSERT INTO EPREUVE (nom_epreuve, type_epreuve, code_exam) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $nom_epreuve, $type_epreuve, $code_exam);
        $stmt->execute();
    }
    $stmt->close();

    // 5. Insérer la correction
    $stmt = $conn->prepare("INSERT INTO CORRIGER (matricule, date_correction, nom_epreuve, nbre_copie) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("issi", $matricule, $date_correction, $nom_epreuve, $nbre_copie);
    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("Location: /gestion-correction/controllers/liste_tables.php");
        exit();
    } else {
        echo "<p style='color:red'>Erreur : " . $stmt->error . "</p>";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="fr-FR">

<head>
    <meta charset="UTF-8">
    <title>Ajouter - Fiche de Correction</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f6fa;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 500px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 16px rgba(0, 0, 0, 0.08);
            padding: 32px 60px;
        }

        h2 {
            text-align: center;
            color: #1976d2;
            margin-bottom: 32px;
            letter-spacing: 1px;
        }

        label {
            margin-bottom: 6px;
            font-weight: 500;
        }

        input[type=text],
        input[type=number],
        input[type=date] {
            padding: 8px 10px;
            border: 1px solid #cfd8dc;
            border-radius: 6px;
            font-size: 1em;
        }
    </style>
</head>

<body>
    <?php include __DIR__ . '/../inclure/navbar.php'; ?>
    <div class="container">
        <h2>📝 FICHE DE CORRECTION</h2>
        <form method="POST" action="">
            <!-- Section Professeur -->
            <fieldset class="mb-4 border border-2 border-primary rounded p-3">
                <legend class="float-none w-auto px-3 fw-bold text-primary">Professeur</legend>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label" for="nom">Nom</label>
                        <input type="text" name="nom" id="nom" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="prenom">Prénom</label>
                        <input type="text" name="prenom" id="prenom" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="grade">Grade</label>
                        <select name="grade" id="grade" class="form-select" required>
                            <option value="">Sélectionner</option>
                            <option value="VIP">VIP</option>
                            <option value="Assistant">Assistant</option>
                            <option value="Chargé de cours">Chargé de cours</option>
                            <option value="Maître Assistant">Maître Assistant</option>
                            <option value="Expert professeur">Expert professeur</option>
                        </select>
                    </div>
                </div>
            </fieldset>

            <!-- Section Établissement -->
            <fieldset class="mb-4 border border-2 border-success rounded p-3">
                <legend class="float-none w-auto px-3 fw-bold text-success">Établissement</legend>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label" for="nom_etab">Nom établissement</label>
                        <input type="text" name="nom_etab" id="nom_etab" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="ville">Ville</label>
                        <input type="text" name="ville" id="ville" class="form-control" required>
                    </div>
                </div>
            </fieldset>

            <!-- Section Examen & Épreuve -->
            <fieldset class="mb-4 border border-2 border-warning rounded p-3">
                <legend class="float-none w-auto px-3 fw-bold text-warning">Examen & Épreuve</legend>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label" for="nom_exam">Nom de l’examen</label>
                        <input type="text" name="nom_exam" id="nom_exam" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="nom_epreuve">Nom de l’épreuve</label>
                        <input type="text" name="nom_epreuve" id="nom_epreuve" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label" for="type_epreuve">Type d’épreuve</label>
                        <select name="type_epreuve" id="type_epreuve" class="form-select">
                            <option value="écrit">Écrit</option>
                            <option value="oral">Oral</option>
                        </select>
                    </div>
                </div>
            </fieldset>

            <!-- Section Correction -->
            <fieldset class="mb-4 border border-2 border-danger rounded p-3">
                <legend class="float-none w-auto px-3 fw-bold text-danger">Correction</legend>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label" for="date_correction">Date de correction</label>
                        <input type="date" name="date_correction" id="date_correction" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="nbre_copie">Nombre de copies / candidats</label>
                        <input type="number" name="nbre_copie" id="nbre_copie" class="form-control" required>
                    </div>
                </div>
            </fieldset>

            <div class="text-end">
                <button type="submit" class="btn btn-success">Enregistrer</button>
                <a href="index.php" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
    <?php include __DIR__ . '/../inclure/footer.php'; ?>
</body>

</html>
<?php $conn->close(); ?>