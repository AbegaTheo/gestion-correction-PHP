<?php
include __DIR__ . '/../config/connect_db.php';
include __DIR__ . '/../inclure/navbar.php';
$table = $_GET['table'] ?? '';
$primaryKeys = [
    'ETABLISSEMENT' => ['code_etab'],
    'PROFESSEUR' => ['matricule'],
    'EXAMEN' => ['code_exam'],
    'EPREUVE' => ['nom_epreuve'],
    'CORRIGER' => ['matricule', 'date_correction', 'nom_epreuve'],
];
if (!isset($primaryKeys[$table])) die('Table non autorisée.');
$pk = $primaryKeys[$table];
$where = [];
$params = [];
$types = '';
foreach ($pk as $key) {
    $where[] = "$key=?";
    $params[] = $_GET[$key];
    $types .= is_numeric($_GET[$key]) ? 'i' : 's';
}
$whereStr = implode(' AND ', $where);
// Suppression manuelle des dépendances
if ($table === 'PROFESSEUR') {
    // Supprimer d'abord les corrections liées
    $stmt = $conn->prepare("DELETE FROM CORRIGER WHERE matricule = ?");
    $stmt->bind_param("i", $_GET['matricule']);
    $stmt->execute();
    $stmt->close();
    // Supprimer aussi les surveillances liées
    $stmt = $conn->prepare("DELETE FROM CORRIGER WHERE matricule = ?");
    $stmt->bind_param("i", $_GET['matricule']);
    $stmt->execute();
    $stmt->close();
}
if ($table === 'EPREUVE') {
    $stmt = $conn->prepare("DELETE FROM CORRIGER WHERE nom_epreuve = ?");
    $stmt->bind_param("s", $_GET['nom_epreuve']);
    $stmt->execute();
    $stmt->close();
}
if ($table === 'EXAMEN') {
    $epreuveResult = $conn->query("SELECT nom_epreuve FROM EPREUVE WHERE code_exam = " . intval($_GET['code_exam']));
    while ($ep = $epreuveResult->fetch_assoc()) {
        $stmt = $conn->prepare("DELETE FROM CORRIGER WHERE nom_epreuve = ?");
        $stmt->bind_param("s", $ep['nom_epreuve']);
        $stmt->execute();
        $stmt->close();
    }
    $conn->query("DELETE FROM EPREUVE WHERE code_exam = " . intval($_GET['code_exam']));
}
if ($table === 'ETABLISSEMENT') {
    $profResult = $conn->query("SELECT matricule FROM PROFESSEUR WHERE code_etab = " . intval($_GET['code_etab']));
    while ($prof = $profResult->fetch_assoc()) {
        $stmt = $conn->prepare("DELETE FROM CORRIGER WHERE matricule = ?");
        $stmt->bind_param("i", $prof['matricule']);
        $stmt->execute();
        $stmt->close();
        // Supprimer aussi les surveillances liées
        $stmt = $conn->prepare("DELETE FROM CORRIGER WHERE matricule = ?");
        $stmt->bind_param("i", $prof['matricule']);
        $stmt->execute();
        $stmt->close();
    }
    $conn->query("DELETE FROM PROFESSEUR WHERE code_etab = " . intval($_GET['code_etab']));
}
// Suppression principale
$stmt = $conn->prepare("DELETE FROM $table WHERE $whereStr");
$stmt->bind_param($types, ...$params);
$stmt->execute();
$stmt->close();
$conn->close();
include __DIR__ . '/../inclure/footer.php';
header('Location: /gestion-correction/controllers/liste_tables.php?success=suppression');
exit();