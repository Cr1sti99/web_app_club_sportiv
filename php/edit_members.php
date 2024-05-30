<?php
// Pornește o sesiune PHP sau reia una existentă
session_start();

// Configurează afișarea erorilor pentru depanare
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include fișierul de configurare pentru baza de date
require_once '../includes/config.php';

// Inițializează un array gol pentru membri
$members = [];

// Interoghează baza de date pentru a obține toți membrii echipei, ordonați alfabetic după nume
$sql = "SELECT id, name, birthdate, team_name FROM team_members ORDER BY name ASC";
if ($result = $conn->query($sql)) {
    // Parcurge rezultatele și adaugă fiecare membru în array-ul $members
    while ($row = $result->fetch_assoc()) {
        $members[] = $row;
    }
    // Eliberează memoria asociată cu rezultatele interogării
    $result->free();
}

// Închide conexiunea la baza de date
$conn->close();
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8"> <!-- Setează codificarea caracterelor -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Asigură o bună afișare pe dispozitive mobile -->
    <title>Editare Membri Echipa</title> <!-- Titlul paginii -->
    <link href="../css/style.css" rel="stylesheet" type="text/css"> <!-- Include fișierul CSS pentru stiluri generale -->
</head>
<body>
    <?php include '../includes/header.php'; ?> <!-- Include fișierul de antet -->
    <main>
        <section id="members">
            <h2>Membrii Echipa</h2> <!-- Titlul secțiunii -->
            <?php
            // Verifică dacă există un mesaj în URL și îl afișează
            if (isset($_GET['message'])) {
                echo '<p class="message">' . htmlspecialchars($_GET['message']) . '</p>';
            }
            ?>
            <a href="../form_member.php">Adaugă Membru</a> <!-- Link pentru adăugarea unui nou membru -->
            <ul>
                <?php foreach ($members as $member): ?>
                    <li>
                        <h3><?= htmlspecialchars($member['name']) ?></h3> <!-- Numele membrului -->
                        <p>Data nașterii: <?= htmlspecialchars($member['birthdate']) ?></p> <!-- Data nașterii -->
                        <p>Echipa: <?= htmlspecialchars($member['team_name']) ?></p> <!-- Numele echipei -->
                        <a href="../form_member.php?id=<?= $member['id'] ?>">Editează</a> | <!-- Link pentru editarea membrului -->
                        <a href="delete_member.php?id=<?= $member['id'] ?>" onclick="return confirm('Ești sigur că vrei să ștergi acest membru?')">Șterge</a> <!-- Link pentru ștergerea membrului -->
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
    </main>
    <?php include '../includes/footer.php'; ?> <!-- Include fișierul de subsol -->
</body>
</html>
