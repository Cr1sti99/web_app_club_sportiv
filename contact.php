<?php
// Pornește o sesiune PHP sau reia una existentă
session_start();

// Configurează afișarea erorilor pentru depanare
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8"> <!-- Setează codificarea caracterelor -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Asigură o bună afișare pe dispozitive mobile -->
    <title>Contact - Retezat Running</title> <!-- Titlul paginii -->
    <meta name="author" content="Cristi Serban"> <!-- Autorul paginii -->
    <meta name="keywords" content="Retezat, Trail, Skyrunning, contact"> <!-- Cuvinte cheie pentru SEO -->
    <meta name="description" content="Contactează-ne pentru mai multe informații"> <!-- Descrierea paginii pentru SEO -->
    <link href="css/style.css" rel="stylesheet" type="text/css"> <!-- Include fișierul CSS pentru stiluri -->
</head>
<body>
    <?php include 'includes/header.php'; ?> <!-- Include fișierul de antet -->
    <main>
        <section id="contact-form">
            <h2>Trimite-ne un mesaj</h2> <!-- Titlul secțiunii de contact -->
            <form action="php/save_message.php" method="POST"> <!-- Formular pentru trimiterea mesajelor, datele sunt trimise către save_message.php -->
                <label for="name">Nume:</label><br> <!-- Etichetă pentru câmpul de nume -->
                <input type="text" id="name" name="name" required><br> <!-- Câmp de input pentru nume -->
                <label for="email">Email:</label><br> <!-- Etichetă pentru câmpul de email -->
                <input type="email" id="email" name="email" required><br> <!-- Câmp de input pentru email -->
                <label for="message">Mesaj:</label><br> <!-- Etichetă pentru câmpul de mesaj -->
                <textarea id="message" name="message" rows="4" required></textarea><br> <!-- Câmp de text pentru mesaj -->
                <input type="submit" value="Trimite"> <!-- Buton de trimitere a formularului -->
            </form>
        </section>
    </main>
    <?php include 'includes/footer.php'; ?> <!-- Include fișierul de subsol -->
</body>
</html>
