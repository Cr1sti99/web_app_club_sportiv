<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../includes/config.php'; // Asigurare cale  corectă

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Pregătim interogarea SQL pentru a șterge anunțul
    $sql = "DELETE FROM announcements WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            // Redirecționăm la pagina de anunțuri cu un mesaj de succes
            header("location: ../announcements.php?message=Anunțul+a+fost+șters+cu+succes.");
            exit();
        } else {
            echo "Ceva nu a mers bine. Te rugăm să încerci din nou.";
        }
        $stmt->close();
    }
} else {
    // Dacă ID-ul nu este valid, redirecționăm înapoi la pagina de anunțuri
    header("location: ../announcements.php");
    exit();
}

$conn->close();
?>
