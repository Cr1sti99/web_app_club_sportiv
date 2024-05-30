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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retezat Running - Anunțuri</title>
    <meta name="author" content="Cristi Serban">
    <meta name="keywords" content="Retezat, Trail, Skyrunning, Anunțuri">
    <meta name="description" content="Anunțurile Clubului Sportiv Retezat Running">
    <link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
    <!-- Include antetul paginii -->
    <?php include 'includes/header.php'; ?>
    <main>
        <section id="announcements">
            <h2>Anunțuri</h2>
            <?php
            // Afișează un mesaj de notificare dacă există în URL
            if (isset($_GET['message'])) {
                echo '<p class="message">' . htmlspecialchars($_GET['message']) . '</p>';
            }
            ?>
            <?php 
            // Verifică dacă utilizatorul este autentificat și afișează butonul de adăugare anunț
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                <a href="form_announcement.php" class="button">Adaugă Anunț</a>
            <?php endif; ?>
            <ul>
                <?php
                // Include fișierul de configurare pentru baza de date
                include 'includes/config.php';

                // Execută interogarea pentru a obține toate anunțurile ordonate descrescător după dată
                $result = $conn->query("SELECT * FROM announcements ORDER BY date DESC");

                // Verifică dacă există anunțuri și le afișează
                if ($result->num_rows > 0) {
                    // Afișează fiecare anunț
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <li>
                            <!-- Afișează titlul anunțului, conținutul și data, protejând împotriva atacurilor XSS -->
                            <h3><?= htmlspecialchars($row['title']) ?></h3>
                            <p><?= htmlspecialchars($row['content']) ?></p>
                            <p><small><?= htmlspecialchars($row['date']) ?></small></p>
                            <?php 
                            // Dacă utilizatorul este autentificat, afișează butoanele de editare și ștergere
                            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                                <a href="form_announcement.php?id=<?= $row['id'] ?>" class="button">Editează</a> | 
                                <a href="php/delete_announcement.php?id=<?= $row['id'] ?>" class="button" onclick="return confirm('Ești sigur că vrei să ștergi acest anunț?')">Șterge</a>
                            <?php endif; ?>
                        </li>
                        <?php
                    }
                } else {
                    // Mesaj afișat dacă nu există anunțuri
                    echo "<p>Nu există anunțuri.</p>";
                }

                // Închide conexiunea la baza de date
                $conn->close();
                ?>
            </ul>
        </section>
    </main>
    <!-- Include subsolul paginii -->
    <?php include 'includes/footer.php'; ?>
</body>
</html>
