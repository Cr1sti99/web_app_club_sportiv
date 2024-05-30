<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Pregătește și execută interogarea pentru a șterge membrul
    $sql = "DELETE FROM team_members WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            // Redirecționează cu un mesaj de succes
            header("Location: ../php/edit_members.php?message=Membru șters cu succes.");
            exit();
        } else {
            // În caz de eroare, redirecționează cu un mesaj de eroare
            header("Location: ../php/edit_members.php?message=Eroare la ștergerea membrului.");
            exit();
        }
        $stmt->close();
    } else {
        // În caz de eroare, redirecționează cu un mesaj de eroare
        header("Location: ../php/edit_members.php?message=Eroare la pregătirea interogării.");
        exit();
    }
} else {
    // În caz de acces nevalid, redirecționează cu un mesaj de eroare
    header("Location: ../php/edit_members.php?message=Acces nevalid.");
    exit();
}

$conn->close();
?>
