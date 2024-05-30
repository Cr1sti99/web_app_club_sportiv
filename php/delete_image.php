<?php
// Pornește o sesiune PHP sau reia una existentă
session_start();

// Configurează afișarea erorilor pentru depanare
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include fișierul de configurare pentru baza de date
require_once '../includes/config.php';

// Verifică dacă utilizatorul este autentificat; dacă nu, redirecționează la pagina de login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login.php");
    exit();
}

// Verifică dacă există un parametru 'id' în URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Convertirea parametrului 'id' la un întreg

    // Pregătește o declarație pentru a selecta numele fișierului din baza de date
    $stmt = $conn->prepare("SELECT file_name FROM gallery_images WHERE id = ?");
    $stmt->bind_param("i", $id); // Leagă parametrii
    $stmt->execute(); // Execută declarația
    $stmt->bind_result($file_name); // Leagă rezultatul la variabila $file_name
    $stmt->fetch(); // Preia rezultatul
    $stmt->close(); // Închide declarația

    // Verifică dacă fișierul există și, dacă da, șterge-l
    if (file_exists($file_name)) {
        unlink($file_name);
    }

    // Pregătește o declarație pentru a șterge înregistrarea din baza de date
    $stmt = $conn->prepare("DELETE FROM gallery_images WHERE id = ?");
    $stmt->bind_param("i", $id); // Leagă parametrii
    $stmt->execute(); // Execută declarația
    $stmt->close(); // Închide declarația

    // Redirecționează la pagina de galerie cu un mesaj de succes
    header("Location: ../gallery.php?message=Imaginea a fost ștearsă cu succes.");
} else {
    // Redirecționează la pagina de galerie cu un mesaj de eroare
    header("Location: ../gallery.php?message=Eroare la ștergerea imaginii.");
}

// Închide conexiunea la baza de date
$conn->close();
?>
