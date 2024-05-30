<?php
// Pornește o sesiune PHP sau reia una existentă
session_start();

// Configurează afișarea erorilor pentru depanare
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include fișierul de configurare pentru baza de date
require_once 'includes/config.php';
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8"> <!-- Setează codificarea caracterelor -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Asigură o bună afișare pe dispozitive mobile -->
    <title>Retezat Running - Galerie</title> <!-- Titlul paginii -->
    <meta name="author" content="Cristi Serban"> <!-- Autorul paginii -->
    <meta name="keywords" content="Retezat, Trail, Skyrunning, Galerie"> <!-- Cuvinte cheie pentru SEO -->
    <meta name="description" content="Galeria Clubului Sportiv Retezat Running"> <!-- Descrierea paginii pentru SEO -->
    <link href="css/style.css" rel="stylesheet" type="text/css"> <!-- Include fișierul CSS pentru stiluri generale -->
    <link href="css/gallery.css" rel="stylesheet" type="text/css"> <!-- Include fișierul CSS specific pentru galerie -->
</head>
<body>
    <?php include 'includes/header.php'; ?> <!-- Include fișierul de antet -->
    <main>
        <section id="image-gallery">
            <h2>Imagini</h2> <!-- Titlul secțiunii de galerie -->
            <div class="image-container">
                <?php
                // Interoghează baza de date pentru a obține imaginile din galerie, ordonate descrescător după data încărcării
                $result = $conn->query("SELECT * FROM gallery_images ORDER BY upload_date DESC");

                // Verifică dacă există imagini în galerie
                if ($result->num_rows > 0) {
                    // Parcurge fiecare imagine și o afișează
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="image-item">';
                        echo '<img src="uploads/' . htmlspecialchars($row["file_name"]) . '" alt="' . htmlspecialchars($row["caption"]) . '">';
                        echo '<div class="image-overlay">';
                        echo '<h3>' . htmlspecialchars($row["caption"]) . '</h3>';
                        // Dacă utilizatorul este autentificat, afișează opțiunea de ștergere a imaginii
                        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                            echo '<a href="php/delete_image.php?id=' . $row["id"] . '" onclick="return confirm(\'Ești sigur că vrei să ștergi această imagine?\')">Șterge</a>';
                        }
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    // Mesaj afișat dacă nu există imagini în galerie
                    echo '<p>Nu există imagini în galerie.</p>';
                }
                // Închide conexiunea la baza de date
                $conn->close();
                ?>
            </div>
        </section>

        <!-- Dacă utilizatorul este autentificat, afișează formularul pentru încărcarea unei noi imagini -->
        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
        <section id="upload-image">
            <h2>Încarcă o imagine</h2>
            <form action="php/upload_image.php" method="post" enctype="multipart/form-data">
                <label for="image">Alege imaginea:</label>
                <input type="file" name="image" id="image" required>
                <label for="caption">Descriere:</label>
                <input type="text" name="caption" id="caption" required>
                <button type="submit">Încarcă</button>
            </form>
        </section>
        <?php endif; ?>
    </main>
    <?php include 'includes/footer.php'; ?> <!-- Include fișierul de subsol -->
</body>
</html>
