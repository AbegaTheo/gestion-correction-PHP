<title>Liste des tables - Fiche de Correction</title>

<?php
include __DIR__ . '/../config/connect_db.php';
$tables = ['ETABLISSEMENT', 'PROFESSEUR', 'EXAMEN', 'EPREUVE', 'CORRIGER'];
$primaryKeys = [
    'ETABLISSEMENT' => ['code_etab'],
    'PROFESSEUR' => ['matricule'],
    'EXAMEN' => ['code_exam'],
    'EPREUVE' => ['nom_epreuve'],
    'CORRIGER' => ['matricule', 'date_correction', 'nom_epreuve'],
];
$success = isset($_GET['success']) && $_GET['success'] === 'suppression';
echo '<!DOCTYPE html><html lang="fr"><head><meta charset="UTF-8"><title>Liste des tables</title><style>
body { background: #f5f6fa; font-family: Arial, sans-serif; }
.center-card { max-width: 950px; margin: 40px auto; background: #fff; border-radius: 18px; box-shadow: 0 2px 18px rgba(0,0,0,0.10); padding: 36px 36px 24px 36px; }
h2 { text-align: center; color: #1976d2; margin-bottom: 32px; letter-spacing: 1px; }
.success-msg { background: #e3fbe3; color: #218838; border: 1px solid #b2e6b2; padding: 12px 18px; border-radius: 7px; margin-bottom: 24px; text-align: center; font-size: 1.08em; }
h3 { margin-top: 36px; color: #1976d2; font-size: 1.15em; letter-spacing: 0.5px; }
table { border-collapse: collapse; width: 100%; margin-bottom: 24px; background: #fafdff; border-radius: 8px; overflow: hidden; }
th,td { border: 1px solid #e3eafc; padding: 9px 12px; text-align: left; }
th { background: #e3eafc; color: #1976d2; font-weight: 600; }
tr:nth-child(even) { background: #f7fafd; }
tr:hover { background: #e3eafc; }
p { color: #888; margin: 10px 0 20px 0; }
.back-btn { display: inline-block; margin: 18px 0 0 0; padding: 10px 28px; background: #1976d2; color: #fff; border: none; border-radius: 7px; font-size: 1em; font-weight: bold; text-decoration: none; transition: background 0.2s; }
.back-btn:hover { background: #125ea7; }
@media (max-width: 1000px) { .center-card { padding: 10px 2vw; } }
.action-links a { margin-right: 8px; color: #1976d2; text-decoration: underline; font-weight: 500; }
.action-links a:last-child { margin-right: 0; }
</style></head><body>';
include __DIR__ . '/../inclure/navbar.php';
echo '<div class="center-card">';
if ($success) {
    echo '<div class="success-msg">Suppression effectuée avec succès.</div>';
}
echo '<h2>Liste des tables</h2>';
foreach ($tables as $table) {
    echo "<h3>$table</h3>";
    $result = $conn->query("SELECT * FROM $table");
    if ($result && $result->num_rows > 0) {
        echo "<table><tr>";
        while ($fieldinfo = $result->fetch_field()) {
            echo "<th>{$fieldinfo->name}</th>";
        }
        echo "<th>Actions</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $cell) {
                echo "<td>" . htmlspecialchars($cell) . "</td>";
            }
            // Générer les liens Modifier/Supprimer
            $pk = $primaryKeys[$table];
            $params = [];
            foreach ($pk as $key) {
                $params[] = urlencode($key) . '=' . urlencode($row[$key]);
            }
            $paramStr = implode('&', $params);
            echo '<td class="action-links">'
                . '<a href="/gestion-correction/controllers/modifier.php?table=' . urlencode($table) . '&' . $paramStr . '">Modifier</a>'
                . '| <a href="/gestion-correction/controllers/supprimer.php?table=' . urlencode($table) . '&' . $paramStr . '" onclick="return confirm(\'Confirmer la suppression ?\')">Supprimer</a>'
                . '</td>';
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Aucune donnée dans cette table.</p>";
    }
}
echo '<a class="back-btn" href="/gestion-correction/controllers/formulaire_correction.php">&#8592; Retour au formulaire</a>';
$conn->close();
echo '</div>';
include __DIR__ . '/../inclure/footer.php';
echo '</body></html>';