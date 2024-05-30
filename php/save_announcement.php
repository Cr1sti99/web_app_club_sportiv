<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../includes/config.php'; // Corectarea căii

// Verificăm dacă formularul a fost trimis prin POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Colectăm datele din formular
    $id = isset($_POST['id']) ? trim($_POST['id']) : '';
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $content = isset($_POST['content']) ? trim($_POST['content']) : '';

    // Verificăm dacă titlul și conținutul sunt completate
    if (!empty($title) && !empty($content)) {
        if (empty($id)) {
            // Inserăm un nou anunț
            $sql = "INSERT INTO announcements (title, content) VALUES (?, ?)";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ss", $title, $content);
                if ($stmt->execute()) {
                    // Redirecționăm la pagina de anunțuri după succes
                    header("location: /Proiect/announcements.php"); // Utilizare adresă absolută
                    exit();
                } else {
                    echo "Ceva nu a mers bine. Te rugăm să încerci din nou.";
                }
                $stmt->close();
            }
        } else {
            // Actualizăm un anunț existent
            $sql = "UPDATE announcements SET title = ?, content = ? WHERE id = ?";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ssi", $title, $content, $id);
                if ($stmt->execute()) {
                    // Redirecționăm la pagina de anunțuri după succes
                    header("location: /Proiect/announcements.php"); // Utilizare adresă absolută
                    exit();
                } else {
                    echo "Ceva nu a mers bine. Te rugăm să încerci din nou.";
                }
                $stmt->close();
            }
        }
    } else {
        echo "Te rugăm să completezi toate câmpurile.";
    }
}

$conn->close();
?>
