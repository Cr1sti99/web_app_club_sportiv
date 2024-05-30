<?php
require_once '../includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Pregătirea și executarea interogării SQL
    $stmt = $conn->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        // Redirecționare la pagina de contact cu un mesaj de succes
        header("Location: ../contact.php?status=success");
    } else {
        // Redirecționare la pagina de contact cu un mesaj de eroare
        header("Location: ../contact.php?status=error");
    }

    $stmt->close();
    $conn->close();
} else {
    // Redirecționare la pagina de contact dacă metoda de solicitare nu este POST
    header("Location: ../contact.php");
}
?>
