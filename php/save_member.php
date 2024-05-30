<?php
// Pornește o sesiune PHP sau reia una existentă
session_start();

// Configurează afișarea erorilor pentru depanare
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include fișierul de configurare pentru baza de date
require_once '../includes/config.php';

// Inițializează un array pentru erori
$errors = [];

// Verifică dacă formularul a fost trimis prin metoda POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Preia datele din formular
    $id = $_POST['id'];
    $name = $_POST['name'];
    $birthdate = $_POST['birthdate'];
    $team_name = $_POST['team_name'];

    // Calculează vârsta pe baza datei de naștere
    $birthdateDateTime = new DateTime($birthdate);
    $today = new DateTime();
    $age = $today->diff($birthdateDateTime)->y;

    // Verifică constrângerile de vârstă pentru fiecare echipă
    if (($team_name == 'Trailblazers' || $team_name == 'Cloud Chasers') && $age < 18) {
        $errors[] = 'Vârsta minimă pentru echipa ' . $team_name . ' este de 18 ani.';
    } elseif ($team_name == 'Trail Cubs' && $age > 18) {
        $errors[] = 'Vârsta maximă pentru echipa Trail Cubs este de 18 ani.';
    } elseif ($team_name == 'Evergreen Runners' && $age < 50) {
        $errors[] = 'Vârsta minimă pentru echipa Evergreen Runners este de 50 ani.';
    }

    // Dacă nu există erori, salvează datele în baza de date
    if (empty($errors)) {
        if (empty($id)) {
            // Adăugare membru nou
            $sql = "INSERT INTO team_members (name, birthdate, team_name) VALUES (?, ?, ?)";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("sss", $name, $birthdate, $team_name);
                $stmt->execute();
                $stmt->close();
            }
        } else {
            // Editare membru existent
            $sql = "UPDATE team_members SET name = ?, birthdate = ?, team_name = ? WHERE id = ?";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("sssi", $name, $birthdate, $team_name, $id);
                $stmt->execute();
                $stmt->close();
            }
        }

        // Redirecționează utilizatorul către pagina de editare membri cu un mesaj de succes
        header("Location: ../php/edit_members.php?message=Membru salvat cu succes.");
        exit;
    }
}

// Închide conexiunea la baza de date
$conn->close();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8"> <!-- Setează codificarea caracterelor -->
    <title>Salvare Membru</title> <!-- Titlul paginii -->
    <link href="../css/style.css" rel="stylesheet" type="text/css"> <!-- Include fișierul CSS pentru stiluri generale -->
</head>
<body>
    <main>
        <div class="wrapper">
            <h2>Salvare Membru</h2> <!-- Titlul secțiunii -->
            <?php 
            // Afișează erorile dacă există
            if (!empty($errors)) {
                echo '<div class="error">';
                foreach ($errors as $error) {
                    echo '<p>' . htmlspecialchars($error) . '</p>';
                }
                echo '</div>';
            }
            ?>
        </div>
    </main>
</body>
</html>
