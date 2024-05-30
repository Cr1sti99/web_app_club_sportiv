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
    header("location: ../login.php");
    exit;
}

// Include fișierul de configurare pentru baza de date
require_once '../includes/config.php';

// Interogare SQL pentru a obține mesajele ordonate descrescător după dată
$sql = "SELECT name, email, message, date FROM messages ORDER BY date DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8"> <!-- Setează codificarea caracterelor -->
    <title>Mesaje Primite</title> <!-- Titlul paginii -->
    <link href="../css/style.css" rel="stylesheet" type="text/css"> <!-- Include fișierul CSS pentru stiluri generale -->
</head>
<body>
<?php include '../includes/header.php'; ?> <!-- Include fișierul de antet -->
    <main>
        <div class="wrapper">
            <h2>Mesaje Primite</h2> <!-- Titlul secțiunii -->
            <?php if ($result->num_rows > 0): ?> <!-- Verifică dacă există mesaje -->
                <ul>
                    <?php while($row = $result->fetch_assoc()): ?> <!-- Parcurge fiecare mesaj -->
                        <li>
                            <p><strong>De la:</strong> <?php echo htmlspecialchars($row['name']); ?></p> <!-- Afișează numele expeditorului -->
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p> <!-- Afișează emailul expeditorului -->
                            <p><?php echo htmlspecialchars($row['message']); ?></p> <!-- Afișează mesajul -->
                            <p><small><?php echo htmlspecialchars($row['date']); ?></small></p> <!-- Afișează data mesajului -->
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>Nu ai mesaje noi.</p> <!-- Mesaj afișat dacă nu există mesaje -->
            <?php endif; ?>
        </div>
    </main>
    <?php include '../includes/footer.php'; ?> <!-- Include fișierul de subsol -->
</body>
</html>
