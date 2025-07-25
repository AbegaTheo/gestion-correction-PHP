<?php
include __DIR__ . '/../inclure/navbar.php';
include __DIR__ . '/../config/connect_db.php';
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
// Récupérer la ligne à modifier
$stmt = $conn->prepare("SELECT * FROM $table WHERE $whereStr");
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();
if (!$row) die('Ligne non trouvée.');
// Traitement de la modification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fields = array_keys($row);
    $set = [];
    $values = [];
    $updateTypes = '';
    foreach ($fields as $field) {
        if (in_array($field, $pk)) continue; // On ne modifie pas la clé primaire
        $set[] = "$field=?";
        $values[] = $_POST[$field];
        $updateTypes .= is_numeric($_POST[$field]) ? 'i' : 's';
    }
    $sql = "UPDATE $table SET ".implode(',', $set)." WHERE $whereStr";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($updateTypes.$types, ...$values, ...$params);
    if ($stmt->execute()) {
        header('Location: /gestion-correction/controllers/liste_tables.php');
        exit();
    } else {
        echo '<p style="color:red">Erreur : '.htmlspecialchars($stmt->error).'</p>';
    }
    $stmt->close();
}
// Affichage du formulaire
function h($v) { return htmlspecialchars($v, ENT_QUOTES); }
echo '<!DOCTYPE html><html lang="fr"><head><meta charset="UTF-8"><title>Modifier</title><style>body{background:#f5f6fa;font-family:Arial,sans-serif;}.center-card{max-width:600px;margin:40px auto;background:#fff;border-radius:16px;box-shadow:0 2px 16px rgba(0,0,0,0.08);padding:32px 40px;}h2{text-align:center;color:#1976d2;margin-bottom:32px;letter-spacing:1px;}.form-row{display:flex;gap:20px;margin-bottom:18px;}.form-group{flex:1;display:flex;flex-direction:column;}label{margin-bottom:6px;font-weight:500;}input[type=text],input[type=number],input[type=date]{padding:8px 10px;border:1px solid #cfd8dc;border-radius:6px;font-size:1em;}.submit-btn{width:100%;background:#1976d2;color:#fff;border:none;padding:14px 0;border-radius:8px;font-size:1.1em;font-weight:bold;cursor:pointer;margin-top:18px;transition:background 0.2s;}.submit-btn:hover{background:#125ea7;}.back-btn{display:inline-block;margin:18px 0 0 0;padding:10px 28px;background:#1976d2;color:#fff;border:none;border-radius:7px;font-size:1em;font-weight:bold;text-decoration:none;transition:background 0.2s;}.back-btn:hover{background:#125ea7;}</style></head><body>';
include __DIR__ . '/../inclure/navbar.php';
echo '<div class="center-card"><h2>Modifier dans '.h($table).'</h2><form method="POST">';
foreach ($row as $field => $value) {
    echo '<div class="form-group">';
    echo '<label>'.h($field).'</label>';
    if (in_array($field, $pk)) {
        echo '<input type="text" name="'.$field.'" value="'.h($value).'" readonly style="background:#f0f0f0">';
    } else {
        $type = is_numeric($value) && strpos($field, 'date') === false ? 'number' : (strpos($field, 'date') !== false ? 'date' : 'text');
        echo '<input type="'.$type.'" name="'.$field.'" value="'.h($value).'">';
    }
    echo '</div>';
}
echo '<button class="submit-btn" type="submit">Enregistrer</button>';
echo '</form><a class="back-btn" href="/gestion-correction/controllers/liste_tables.php">&#8592; Retour à la liste</a></div>';
include __DIR__ . '/../inclure/footer.php';
echo '</body></html>'; 