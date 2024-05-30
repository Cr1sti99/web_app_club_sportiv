<?php
// Pornește o sesiune PHP sau reia una existentă
session_start();

// Configurează afișarea erorilor pentru depanare
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include fișierul de configurare pentru baza de date
require_once '../includes/config.php';

// Verifică dacă formularul a fost trimis prin metoda POST și dacă fișierul a fost încărcat fără erori
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
    $target_dir = "../uploads/"; // Directorul țintă unde va fi încărcat fișierul
    $target_file = $target_dir . basename($_FILES["image"]["name"]); // Calea completă a fișierului țintă
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); // Extensia fișierului

    // Verifică dacă fișierul este o imagine reală
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check === false) {
        die("Fișierul nu este o imagine.");
    }

    // Verifică dimensiunea fișierului
    if ($_FILES["image"]["size"] > 5000000) { // Limita de 5MB
        die("Ne pare rău, fișierul este prea mare.");
    }

    // Permite doar anumite formate de fișiere
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    if(!in_array($imageFileType, $allowed_types)) {
        die("Ne pare rău, doar fișierele JPG, JPEG, PNG și GIF sunt permise.");
    }

    // Verifică dacă fișierul există deja
    if (file_exists($target_file)) {
        die("Ne pare rău, fișierul există deja.");
    }

    // Mută fișierul în directorul țintă
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        // Pregătește și execută interogarea pentru a insera informațiile fișierului în baza de date
        $stmt = $conn->prepare("INSERT INTO gallery_images (file_name, caption) VALUES (?, ?)");
        $stmt->bind_param("ss", $target_file, $_POST["caption"]);
        $stmt->execute();
        $stmt->close();
        // Redirecționează utilizatorul la pagina galeriei după încărcare
        header("Location: ../gallery.php");
        exit();
    } else {
        die("Ne pare rău, a apărut o eroare la încărcarea fișierului.");
    }
}
?>
