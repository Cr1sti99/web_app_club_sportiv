<?php
// Pornește o sesiune PHP sau reia una existentă
session_start();

// Configurează afișarea erorilor pentru depanare
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include fișierul de configurare pentru baza de date
require_once '../includes/config.php';

// Verifică dacă utilizatorul este autentificat
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // Definirea echipelor
    $teams = ['Trailblazers', 'Cloud Chasers', 'Trail Cubs', 'Evergreen Runners'];
    $result = [];

    // Parcurge fiecare echipă
    foreach ($teams as $team) {
        // Pregătește declarația SQL pentru a selecta membrii echipei curente
        $stmt = $conn->prepare("SELECT name FROM team_members WHERE team_name = ?");
        $stmt->bind_param("s", $team); // Leagă parametrii
        $stmt->execute(); // Execută declarația
        $stmt->bind_result($name); // Leagă rezultatul la variabila $name

        // Inițializează un array pentru membrii echipei
        $members = [];
        while ($stmt->fetch()) {
            $members[] = ['name' => $name]; // Adaugă fiecare membru în array
        }
        $stmt->close(); // Închide declarația

        // Adaugă echipa și membrii săi în rezultatul final
        $result[] = ['team_name' => $team, 'members' => $members];
    }

    // Returnează rezultatul ca JSON
    echo json_encode($result);
} else {
    // Returnează un array gol dacă utilizatorul nu este autentificat
    echo json_encode([]);
}

// Închide conexiunea la baza de date
$conn->close();
?>
