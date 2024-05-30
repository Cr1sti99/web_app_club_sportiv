<?php
// Pornește o sesiune PHP sau reia una existentă
session_start();

// Configurează afișarea erorilor pentru depanare
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verificăm dacă utilizatorul este autentificat
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Dacă utilizatorul nu este autentificat, redirecționează-l către pagina de login
    header("location: login.php");
    exit;
}

// Verificăm dacă utilizatorul este admin
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8"> <!-- Setează codificarea caracterelor -->
    <title>Opțiuni</title> <!-- Titlul paginii -->
    <link href="../css/style.css" rel="stylesheet" type="text/css"> <!-- Include fișierul CSS pentru stiluri generale -->
</head>
<body>
    <?php include '../includes/header.php'; ?> <!-- Include fișierul de antet -->
    <main>
        <div class="wrapper">
            <h2>Bine ai venit, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2> <!-- Afișează mesajul de bun venit cu numele utilizatorului autentificat -->
            <p>Te rog să alegi o opțiune:</p> <!-- Instrucțiuni pentru utilizatori -->
            <a href="../announcements.php" class="button">Editează Anunțuri</a> <!-- Buton pentru editarea anunțurilor -->
            <?php if ($isAdmin): ?> <!-- Verifică dacă utilizatorul este admin -->
                <a href="../php/edit_members.php" class="button">Editează Membrii Echipei</a> <!-- Buton pentru editarea membrilor echipei, vizibil doar pentru admin -->
            <?php endif; ?>
            <a href="../php/view_messages.php" class="button">Vizualizează Mesaje Primite</a> <!-- Buton pentru vizualizarea mesajelor primite -->
        </div>
    </main>
    <?php include '../includes/footer.php'; ?> <!-- Include fișierul de subsol -->
</body>
</html>
